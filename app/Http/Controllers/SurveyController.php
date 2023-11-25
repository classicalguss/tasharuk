<?php

namespace App\Http\Controllers;

use App\Mail\SurveyMailer;
use App\Models\Capability;
use App\Models\Indicator;
use App\Models\School;
use App\Models\Stakeholder;
use App\Models\Subcapability;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SurveyController extends Controller
{
	/**
	 * Redirect to user-management view.
	 *
	 */
	public function SurveyManagement()
	{
		return view('pages.surveys');
	}

	public function index(Request $request) {
		$limit = $request->input('length');
		$start = $request->input('start');
		$totalData = Survey::count();
		$totalFiltered = $totalData;
		if (empty($request->input('search.value'))) {
			$surveys = Survey::with('school', 'stakeholder')->limit($limit);
		} else {
			$search = $request->input('search.value');

			$surveys = Survey::with('school', 'stakeholder')
				->where('receiver_email', 'LIKE', "%{$search}%")
				->offset($start)
				->limit($limit);

			$totalFiltered = Survey::where('receiver_email', 'LIKE', "%{$search}%")
				->count();
		}
		foreach ($surveys as $survey) {
			$survey->created_at = $survey->created_at->format('Y-m-d H:i:s');
		}
		return response()->json([
			'code' => 200,
			'data' => $surveys->get(),
			'recordsFiltered' => $totalFiltered,
			'recordsTotal' => $totalData
		]);
	}

	//
	public function sendPage()
	{
		$stakeholders = Stakeholder::all();
		$schools = School::all();
		return view('pages.surveys.send', [
			'stakeholders' => $stakeholders,
			'schools' => $schools
		]);
	}

	public function send(Request $request)
	{
		$data = [];
		$emails = json_decode($request->post('mailing-list'), true);

		$survey = new Survey();
		$survey->stakeholder_id = $request->post('stakeholder_id');
		$survey->school_id = $request->post('school_id');
		$survey->initialize();

		$school = School::find($request->post('school_id'));
		foreach ($emails as $email) {
			$token = Survey::generateInvitationToken($email['value']);
			$data[] = [
				'receiver_email' => $email['value'],
				'stakeholder_id' => $request->post('stakeholder_id'),
				'school_id' => $school->id,
				'indicator_id' => $survey->indicator_id,
				'status' => 'not_started',
				"created_at" => date('Y-m-d H:i:s'),
				"updated_at" => date('Y-m-d H:i:s'),
				'invitation_token' => $token
			];
			Mail::to($email['value'])->send(new SurveyMailer($school->name, $token));
		}
		Survey::insert($data);
		toastr()->success(count($data) . ' surveys were sent successfully');
		return redirect()->back();
	}

	public function rate(Survey $survey, Request $request)
	{
		$surveyAnswer = new SurveyAnswer();
		$surveyAnswer->survey_id = $survey->id;
		$surveyAnswer->score = $request->post('rate');
		$surveyAnswer->indicator_id = $survey->indicator_id;
		$surveyAnswer->save();
		$survey->getNextIndicator();
		return redirect()->back();
	}

	public function complete()
	{
		return view('pages.surveys.done');
	}

	public function survey(Request $request) {
		$survey = Survey::where([
			'invitation_token' => $request->get('token')
		])->first();

		if ($survey->status == 'completed')
			return view('pages.surveys.done');

		if ($request->get('begin')) {
			$survey->status = 'progress';
			$survey->save();
		}

		$indicatorsCount = Indicator::count();
		$surveyAnswers = SurveyAnswer::whereSurveyId($survey->id)->count();
		$progress = (($surveyAnswers + 1) / ($indicatorsCount + 1)) * 100;

		$isFirst = $survey->status == 'not_started';
		$ratings = [
			'Highly Effective',
			'Effective',
			'Satisfactory',
			'Needs improvement',
			'Does not meet standard'
		];
		return view('pages.surveys.survey',[
			'progress' => $progress,
			'ratings' => $ratings,
			'survey' => $survey,
			'capability' => $survey->indicator->subcapability->capability->name,
			'subcapability' => $survey->indicator->subcapability->name,
			'indicator' => $survey->indicator,
			'isFirst' => $isFirst
		]);
	}
}
