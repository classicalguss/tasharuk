import * as alpine from 'alpinejs/dist/cdn';
import axios from 'axios';

export { alpine };

const colors = ['success', 'danger', 'secondary', 'warning', 'info', 'dark', 'primary'];
function avatar(user) {
    let $output = '';
    if (user['profile_photo_url']) {
        $output = '<img src="'+user['profile_photo_url']+'" alt="" class="rounded-circle">';
    } else {
        let colorClass = colors[user['id'] % 7],
            $initials = user['name'].match(/\b\w/g) || [];
        $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
        $output = '<span class="avatar-initial rounded-circle bg-label-' + colorClass + '">' + $initials + '</span>';
    }
    return $output;
}

function schoolLogo(school) {
    let $output = '';
    if (school['logo']) {
        $output = '<img src="'+school['logo']+'" alt="">';
    } else {
        $output = '<img src="/assets/img/school-default.png" alt="">';
    }
    return $output;
}

export {avatar, schoolLogo}

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';