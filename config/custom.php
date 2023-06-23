<?php

// Custom Config
// -------------------------------------------------------------------------------------
//! IMPORTANT: Make sure you clear the browser local storage In order to see the config changes in the template.
//! To clear local storage: (https://www.leadshook.com/help/how-to-clear-local-storage-in-google-chrome-browser/).

return [
  'custom' => [
    'myLayout' => 'vertical', // Options[String]: vertical(default), horizontal  HORIZONTAL LAYOUT WOULD NOT WORK WITH SEMI DARK THEME
    'myTheme' => 'theme-default', // Options[String]: theme-default(default), theme-bordered, theme-semi-dark  SEMI-DARK THEME WOULD NOT WORK WITH HORIZONTAL LAYOUT
    'myStyle' => 'light', // Options[String]: light(default), dark
    'myRTLSupport' => true, // options[Boolean]: true(default), false // To provide RTLSupport or not
    'myRTLMode' => true, // options[Boolean]: false(default), true // To set layout to RTL layout  (myRTLSupport must be true for rtl mode)
    'menuFixed' => true, // options[Boolean]: true(default), false // Layout(menu) Fixed
    'menuCollapsed' => false, // options[Boolean]: false(default), true // Show menu collapsed, Only for vertical Layout
    'navbarFixed' => false, // options[Boolean]: false(default), true // Navbar Fixed
    'footerFixed' => false, // options[Boolean]: false(default), true // Footer Fixed
    'showDropdownOnHover' => true, // true, false (for horizontal layout only)
    'customizerControls' => [
      'rtl',
      'style',
      'layoutType',
      'showDropdownOnHover',
      'layoutNavbarFixed',
      'layoutFooterFixed',
      'themes',
    ], // To show/hide customizer options
  ],
];