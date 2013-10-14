<?php
function big_calendar_month() {
  require_once("frontend_functions.php");
  global $wpdb;
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 0);
  $many_sp_calendar = ((isset($_GET['many_sp_calendar']) && is_numeric(esc_html($_GET['many_sp_calendar']))) ? esc_html($_GET['many_sp_calendar']) : 1);
  $calendar_id = (isset($_GET['calendar']) ? (int) $_GET['calendar'] : '');
  $theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : 13);
  $date = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : '');
  $view_select = (isset($_GET['select']) ? esc_html($_GET['select']) : 'month,');
  $path_sp_cal = (isset($_GET['cur_page_url']) ? esc_html($_GET['cur_page_url']) : '');

  $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d', $theme_id));
  $cal_width = $theme->width;
  $bg_top = '#' . $theme->bg_top;
  $bg_bottom = '#' . $theme->bg_bottom;
  $border_color = '#' . $theme->border_color;
  $text_color_year = '#' . $theme->text_color_year;
  $text_color_month = '#' . $theme->text_color_month;
  $color_week_days = '#' . $theme->text_color_week_days;
  $text_color_other_months = '#' . $theme->text_color_other_months;
  $text_color_this_month_unevented = '#' . $theme->text_color_this_month_unevented;
  $evented_color = '#' . $theme->text_color_this_month_evented;
  $evented_color_bg = '#' . $theme->bg_color_this_month_evented;
  $color_arrow_year = '#' . $theme->arrow_color_year;
  $color_arrow_month = '#' . $theme->arrow_color_month;
  $sun_days = '#' . $theme->text_color_sun_days;
  $event_title_color = '#' . $theme->event_title_color;
  $current_day_border_color = '#' . $theme->current_day_border_color;
  $cell_border_color = '#' . $theme->cell_border_color;
  $cell_height = $theme->cell_height;
  $popup_width = $theme->popup_width;
  $popup_height = $theme->popup_height;
  $number_of_shown_evetns = $theme->number_of_shown_evetns;
  $sundays_font_size = $theme->sundays_font_size;
  $other_days_font_size = $theme->other_days_font_size;
  $weekdays_font_size = $theme->weekdays_font_size;
  $border_width = $theme->border_width;
  $top_height = $theme->top_height;
  $bg_color_other_months = '#' . $theme->bg_color_other_months;
  $sundays_bg_color = '#' . $theme->sundays_bg_color;
  $weekdays_bg_color = '#' . $theme->weekdays_bg_color;
  $weekstart = $theme->week_start_day;
  $weekday_sunday_bg_color = '#' . $theme->weekday_sunday_bg_color;
  $border_radius = $theme->border_radius;
  $border_radius2 = $border_radius-$border_width;
  $week_days_cell_height = $theme->week_days_cell_height;
  $year_font_size = $theme->year_font_size;
  $month_font_size = $theme->month_font_size;
  $arrow_size = $theme->arrow_size;
  $arrow_size_hover = $arrow_size + 5;
  $next_month_text_color = '#' . $theme->next_month_text_color;
  $prev_month_text_color = '#' . $theme->prev_month_text_color;
  $next_month_arrow_color = '#' . $theme->next_month_arrow_color;
  $prev_month_arrow_color = '#' . $theme->prev_month_arrow_color;
  $next_month_font_size = $theme->next_month_font_size;
  $prev_month_font_size = $theme->prev_month_font_size;
  $month_type = $theme->month_type;
  $ev_title_bg_color = '#'.$theme->ev_title_bg_color;

  $date_bg_color = '#' . $theme->date_bg_color;
  $event_bg_color1 = '#' . $theme->event_bg_color1;
  $event_bg_color2 = '#' . $theme->event_bg_color2;
  $event_num_bg_color1 = '#' . $theme->event_num_bg_color1;
  $event_num_bg_color2 = '#' . $theme->event_num_bg_color2;
  $event_num_color = '#' . $theme->event_num_color;
  $date_font_size = $theme->date_font_size;
  $event_num_font_size = $theme->event_num_font_size;
  $event_table_height = $theme->event_table_height;
  $date_height = $theme->date_height;
  $day_month_font_size = $theme->day_month_font_size;
  $week_font_size = $theme->week_font_size;
  $day_month_font_color = '#' . $theme->day_month_font_color;
  $week_font_color = '#' . $theme->week_font_color;
  $views_tabs_bg_color = '#' . $theme->views_tabs_bg_color;
  $views_tabs_text_color = '#' . $theme->views_tabs_text_color;
  $views_tabs_font_size = $theme->views_tabs_font_size;
  $show_numbers_for_events = $theme->day_start;

  __('January', 'sp_calendar');
  __('February', 'sp_calendar');
  __('March', 'sp_calendar');
  __('April', 'sp_calendar');
  __('May', 'sp_calendar');
  __('June', 'sp_calendar');
  __('July', 'sp_calendar');
  __('August', 'sp_calendar');
  __('September', 'sp_calendar');
  __('October', 'sp_calendar');
  __('November', 'sp_calendar');
  __('December', 'sp_calendar');
  if ($cell_height == '') {
    $cell_height = 70;
  }
  if ($cal_width == '') {
    $cal_width = 700;
  }
  if ($date != '') {
    $date_REFERER = $date;
  }
  else {
    $date_REFERER = date("Y-m");
    $date = date("Y") . '-' . php_Month_num(date("F")) . '-' . date("d");
  }
  
  $year_REFERER = substr($date_REFERER, 0, 4);
  $month_REFERER = Month_name(substr($date_REFERER, 5, 2));
  $day_REFERER = substr($date_REFERER, 8, 2);

  $year = substr($date, 0, 4);
  $month = Month_name(substr($date, 5, 2));
  $day = substr($date, 8, 2);

  $cell_width = $cal_width / 7;
  $cell_width = (int) $cell_width - 2;
  
  $this_month = substr($year . '-' . add_0((Month_num($month))), 5, 2);
  $prev_month = add_0((int) $this_month - 1);
  $next_month = add_0((int) $this_month + 1);

  $view = 'bigcalendarmonth';
  $views = explode(',', $view_select);
  $defaultview = 'month';
  array_pop($views);
  $display = '';
  if (count($views) == 0) {
    $display = "display:none";
  }
  if(count($views) == 1 && $views[0] == $defaultview) {
    $display = "display:none";
  }
  ?>
  <style type='text/css'>
    #TB_window {
      z-index: 10000;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calyear_table td {
      vertical-align: middle !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> table {
      border-collapse: initial;
      border:0px;
      max-width: none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> table tr:hover td {
      background: none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> table td {
      padding: 0px;
      vertical-align: none;
      border-top:none;
      line-height: none;
      text-align: none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> p, ol, ul, dl, address {
      margin-bottom:0;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> td,
    #bigcalendar<?php echo $many_sp_calendar; ?> tr,
    #spiderCalendarTitlesList td,
    #spiderCalendarTitlesList tr {
      border:none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .general_table {
      border-radius: <?php echo $border_radius; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .top_table {
      border-top-left-radius: <?php echo $border_radius2; ?>px;
      border-top-right-radius: <?php echo border_radius2; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:link,
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:visited {
      text-decoration:none;
      background:none;
      font-size: <?php echo $arrow_size; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:hover {
      text-decoration:none;
      background:none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:link,
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:visited {
      text-decoration:none;
      background:none;
      font-size:12px;
      color:red;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:hover {
      text-decoration:none;
      background:none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day {
      border:1px solid <?php echo $cell_border_color; ?>;
      vertical-align:top;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .weekdays {
      border: 1px solid <?php echo $cell_border_color; ?>;
      vertical-align: middle;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .week_days {
      font-size:<?php echo $weekdays_font_size; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calyear_table {
      border-spacing:0;
      width:100%;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calmonth_table {	
      border-spacing:0;
      width:100%;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calbg,
    #bigcalendar<?php echo $many_sp_calendar; ?> .calbg td {
      text-align:center;
      width:14%;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_other_months {
      color:<?php echo $text_color_other_months; ?>;
      border:1px solid <?php echo $cell_border_color; ?>;
      vertical-align:top;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_this_month_unevented {
      color:<?php echo $text_color_this_month_unevented; ?>;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calfont_year {
      font-size:24px;
      font-weight:bold;
      color:<?php echo $text_color_year; ?>;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calsun_days {
      color:<?php echo $sun_days; ?>;
      border:1px solid <?php echo $cell_border_color; ?>;
      vertical-align:top;
      text-align:left;
      background-color: <?php echo $sundays_bg_color; ?>;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .views {
      float: right;
      background-color: <?php echo $views_tabs_bg_color; ?>;
      height: 25px;
      width: 70px;
      margin-right: 2px;
      text-align: center;
      cursor:pointer;
      position: relative;
      top: 5px;
    }
  </style>
  <div style="width:<?php echo $cal_width; ?>px;">
    <table cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <div id="views_tabs" style="<?php echo $display ?>">
            <div class="views" style="<?php if (!in_array('day', $views) AND $defaultview != 'day') echo 'display:none;'; if ($view == 'bigcalendarday') echo 'background-color:' . $bg_top . ';height:30px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_day',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))) . '-' . date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
                'widget' => $widget,
                ), admin_url('admin-ajax.php'));?>')" ><span style="position:relative;top:15%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Day', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('week', $views) AND $defaultview != 'week') echo 'display:none;'; if ($view == 'bigcalendarweek') echo 'background-color:' . $bg_top . ';height:30px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_week',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                'date' => $year . '-' . add_0((Month_num($month))) . '-' . date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
                'widget' => $widget,
                ), admin_url('admin-ajax.php'));?>')" ><span style="position:relative;top:15%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Week', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('list', $views) AND $defaultview != 'list') echo 'display:none;'; if ($view == 'bigcalendarlist') echo 'background-color:' . $bg_top . ';height:30px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_list',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
                'widget' => $widget,
                ), admin_url('admin-ajax.php'));?>')"><span style="position:relative;top:15%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('List', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('month', $views) AND $defaultview != 'month') echo 'display:none;'; if ($view == 'bigcalendarmonth') echo 'background-color:' . $bg_top . ';height:30px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_month',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
                'widget' => $widget,
                ), admin_url('admin-ajax.php'));?>')" ><span style="position:relative;top:15%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Month', 'sp_calendar'); ?></span>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <table cellpadding="0" cellspacing="0" class="general_table"  style="border-spacing:0; width:<?php echo $cal_width; ?>px;border:<?php echo $border_color; ?> solid <?php echo $border_width; ?>px; margin:0; padding:0;background-color:<?php echo $bg_bottom; ?>;">
            <tr>
              <td width="100%" style="padding:0; margin:0">
                <table cellpadding="0" cellspacing="0" border="0" style="border-spacing:0; font-size:12px; margin:0; padding:0; width="<?php echo $cal_width; ?>;">
                  <tr style="height:40px; width:<?php echo $cal_width; ?>px;">
                    <td class="top_table" align="center" colspan="7" style="background-image:url('<?php echo plugins_url('/images/Stver.png', __FILE__); ?>');padding:0; margin:0; background-color:<?php echo $bg_top; ?>;height:20px; background-repeat: no-repeat;background-size: 100% 100%;">
                      <table cellpadding="0" cellspacing="0" border="0" align="center" class="calyear_table" style="margin:0; padding:0; text-align:center; width:<?php echo $cal_width; ?>px; height:<?php echo $top_height; ?>px;">
                        <tr>
                          <td width="15%">
                            <div onclick="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php 
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => ($year - 1) . '-' . add_0(Month_num($month)),
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                ), admin_url('admin-ajax.php'));?>')" style="text-align:center; cursor:pointer; width:100%; height:35px; background-color:#000000; filter:alpha(opacity=30); opacity:0.3;">
                              <span style="font-size:23px;color:<?php echo $bg_top; ?>"><?php echo $year - 1; ?></span>
                            </div>
                          </td>
                          <td class="cala_arrow" width="15%" style="text-align:right;margin:0px;padding:0px">
                            <a style="text-shadow: 1px 1px 2px black;color:<?php echo $color_arrow_month ?>;" href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                              if (Month_num($month) == 1) {
                                $needed_date = ($year - 1) . '-12';
                              }
                              else {
                                $needed_date = $year . '-' . add_0((Month_num($month) - 1));
                              }
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => $needed_date,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                ), admin_url('admin-ajax.php'));
                              ?>')">&#9668;
                            </a>
                          </td>
                          <td style="text-align:center; margin:0;" width="40%">
                            <input type="hidden" name="month" readonly="" value="<?php echo $month; ?>"/>
                            <span style="font-family:arial; color:<?php echo $text_color_month; ?>; font-size:<?php echo $month_font_size; ?>px;text-shadow: 1px 1px  black;"><?php echo $year . ', ' . __($month, 'sp_calendar'); ?></span>
                          </td>
                          <td style="margin:0; padding:0;text-align:left" width="15%" class="cala_arrow">
                            <a style="text-shadow: 1px 1px 2px black;color:<?php echo $color_arrow_month; ?>" href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                              if (Month_num($month) == 12) {
                                $needed_date = ($year + 1) . '-01';
                              }
                              else {
                                $needed_date = $year . '-' . add_0((Month_num($month) + 1));
                              }
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => $needed_date,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                ), admin_url('admin-ajax.php'));
                              ?>')">&#9658;
                            </a>
                          </td>
                          <td width="15%">
                            <div onclick="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php 
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => ($year + 1) . '-' . add_0(Month_num($month)),
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                ), admin_url('admin-ajax.php'));?>')" style="text-align:center; cursor:pointer; width:100%; height:35px; background-color:#000000; filter:alpha(opacity=30); opacity:0.3;">
                              <span style="font-size:23px;color:<?php echo $bg_top; ?>"><?php echo $year + 1; ?></span>
                            </div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr align="center" height="<?php echo $week_days_cell_height; ?>" style="background-color:<?php echo $weekdays_bg_color; ?>;">
                    <?php if ($weekstart == "su") { ?>
                      <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days;?>; margin:0; padding:0;background-color:<?php echo $weekday_sunday_bg_color; ?>">
                        <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Su', 'sp_calendar'); ?> </b></div>
                      </td>
                    <?php } ?>
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Mo', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Tu', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('We', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Th', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Fr', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px;	color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Sa', 'sp_calendar'); ?> </b></div>
                    </td>
                    <?php if ($weekstart == "mo") { ?>			 
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px; color:<?php echo $color_week_days;?>; margin:0; padding:0;background-color:<?php echo $weekday_sunday_bg_color; ?>">
                      <div class="calbottom_border" style="text-align:center; width:<?php echo $cell_width; ?>px; margin:0; padding:0;"><b class="week_days"><?php echo __('Su', 'sp_calendar'); ?> </b></div>
                    </td>
                    <?php } ?>
                  </tr>
  <?php
  $month_first_weekday = date("N", mktime(0, 0, 0, Month_num($month), 1, $year));
  if ($weekstart == "su") {
    $month_first_weekday++;
    if ($month_first_weekday == 8) {
      $month_first_weekday = 1;
    }
  }
  $month_days = date("t", mktime(0, 0, 0, Month_num($month), 1, $year));
  $last_month_days = date("t", mktime(0, 0, 0, Month_num($month) - 1, 1, $year));
  $weekday_i = $month_first_weekday;
  $last_month_days = $last_month_days - $weekday_i + 2;
  $percent = 1;
  $sum = $month_days - 8 + $month_first_weekday;
  if ($sum % 7 <> 0) {
    $percent = $percent + 1;
  }
  $sum = $sum - ($sum % 7);
  $percent = $percent + ($sum / 7);
  $percent = 107 / $percent;
  $all_calendar_files = php_getdays($show_numbers_for_events, $calendar_id, $date, $theme_id, $widget);
  $array_days = $all_calendar_files[0]['array_days'];
  $array_days1 = $all_calendar_files[0]['array_days1'];
  $title = $all_calendar_files[0]['title'];
  $ev_ids = $all_calendar_files[0]['ev_ids'];
  echo '          <tr id="days"  height="' . $cell_height . '" style="line-height:15px;">';
  for ($i = 1; $i < $weekday_i; $i++) {
    echo '          <td class="caltext_color_other_months" style="background-color:' . $bg_color_other_months . '">
                      <span style="font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family: tahoma;padding-left: 5px;">' . $last_month_days . '</span>
                    </td>';
    $last_month_days = $last_month_days + 1;
  }
  for ($i = 1; $i <= $month_days; $i++) {
    if (isset($title[$i])) {
      $ev_title = explode('</p>', $title[$i]);
      array_pop($ev_title);
      $k = count($ev_title);
      $ev_id = explode('<br>', $ev_ids[$i]);
      array_pop($ev_id);
      $ev_ids_inline = implode(',', $ev_id);
    }
    $dayevent = '';
    if (($weekday_i % 7 == 0 and $weekstart == "mo") or ($weekday_i % 7 == 1 and $weekstart == "su")) {
      if ($i == $day_REFERER and $month == $month_REFERER and $year == $year_REFERER ) {
        echo '      <td bgcolor="' . $bg_color_selected . '" class="cala_day" style="padding:0; margin:0;line-height:15px;">
                      <div class="calborder_day" style=" width:' . $cell_width . 'px; margin:0; padding:0;">
                        <p style="color:' . $evented_color . ';line-height:1.3;font-family: tahoma;padding-left: 5px;text-shadow: 1px 1px white;">' . $i . '</p>';
        $r = 0;
        echo '          <div style="background-color:' . $ev_title_bg_color . ';">';
        for ($j = 0; $j < $k; $j++) {
          if ($r < $number_of_shown_evetns) {
            echo '        <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none;color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . $ev_title[$j] . '</b>
                          </a>';
          }
          else {
            echo '        <br>
                          <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="font-size:11px; background:none; color:' . $event_title_color . '; text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a>';
            break;
          }
          $r++;
        }
        echo '          </div>
                      </div>
                    </td>';
      }
      elseif ($i == date('j') and $month == date('F') and $year == date('Y')) {
        if (in_array($i,$array_days)) {
          echo '      <td class="cala_day" style="background-color:' . $ev_title_bg_color . ';padding:0; margin:0;line-height:15px; border: px solid ' . $border_day . '">
                        <p style="background-color:' . $evented_color_bg . ';color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;text-shadow: 1px 1px white;">' . $i . '</p>';
          $r = 0;
          echo '        <div style="background-color:' . $ev_title_bg_color . '">';
          for ($j = 0; $j < $k; $j++) {
            if ($r < $number_of_shown_evetns) {
              echo '      <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none;color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . $ev_title[$j] . '</b>
                          </a>';
            }
            else {
              echo '      <br>
                          <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="font-size:11px;background:none;color:' . $event_title_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a>';
              break;
            }
            $r++;
          }
          echo '        </div>
                      </td>';
        }
        else {
          echo '      <td class="calsun_days" style="padding:0; font-size:' . $sundays_font_size . 'px; margin:0;line-height:1.3;font-family:tahoma;padding-left: 5px; border: 1px solid ' . $border_day . '">
                        <b>' . $i . '</b>
                      </td>';
        }
      }
      elseif (in_array($i, $array_days)) {
        echo '        <td class="cala_day" style="background-color:' . $ev_title_bg_color . ';padding:0; margin:0;line-height:15px;">
                        <p style="background-color:' . $evented_color_bg . ';color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;text-shadow: 1px 1px white;">' . $i . '</p>
                        <div style="background-color:' . $ev_title_bg_color . '">';
        $r = 0;
        for ($j = 0; $j < $k; $j++) {
          if ($r < $number_of_shown_evetns) {
            echo '        <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none; color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . $ev_title[$j] . '</b>
                          </a>';
          }
          else {
            echo '        <br>
                          <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="font-size:11px; background:none; color:' . $event_title_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a>';
            break;
          }
          $r++;
        }
        echo '          </div>
                      </td>';
			}
      else {
        echo '        <td class="calsun_days" style="padding:0; margin:0;line-height:1.3;font-family: tahoma;padding-left: 5px;font-size:' . $sundays_font_size . 'px">
                        <b>' . $i . '</b>
                      </td>';
      }
    }
    elseif ($i == $day_REFERER and $month == $month_REFERER and $year == $year_REFERER) {
			echo '          <td bgcolor="' . $bg_color_selected . '" class="cala_day" style="padding:0; margin:0;line-height:15px;">
                        <div class="calborder_day" style="width:' . $cell_width . 'px; margin:0; padding:0;">
                          <p style="background-color:' . $evented_color_bg . ';color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family: tahoma;padding-left: 5px;text-shadow: 1px 1px white;">' . $i . '</p>
                          <div style="background-color:' . $ev_title_bg_color . '">';
      $r = 0;
			for ($j = 0; $j < $k; $j++) {
        if ($r < $number_of_shown_evetns) {
          echo '            <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none; color:' . $event_title_color . ';"
                              href="' . add_query_arg(array(
                                'action' => 'spidercalendarbig',
                                'theme_id' => $theme_id,
                                'calendar_id' => $calendar_id,
                                'ev_ids' => $ev_ids_inline,
                                'eventID' => $ev_id[$j],
                                'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                'TB_iframe' => 1,
                                'tbWidth' => $popup_width,
                                'tbHeight' => $popup_height,
                                ), admin_url('admin-ajax.php')) . '"><b>' . $ev_title[$j] . '</b>
                            </a>';
          }
          else {
              echo '        <br>
                            <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="font-size:11px; background:none; color:' . $event_title_color . ';text-align:center;"
                              href="' . add_query_arg(array(
                                'action' => 'spiderseemore',
                                'theme_id' => $theme_id,
                                'calendar_id' => $calendar_id,
                                'ev_ids' => $ev_ids_inline,
                                'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                'TB_iframe' => 1,
                                'tbWidth' => $popup_width,
                                'tbHeight' => $popup_height,
                                ), admin_url('admin-ajax.php')) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                            </a>';
            break;
          }
          $r++;
        }
        echo '            </div>
                        </div>
                      </td>';
      }
      else {
        if ($i == date('j') and $month == date('F') and $year == date('Y')) {
          if (in_array ($i,$array_days)) {
            echo  '   <td class="cala_day" style="background-color:' . $ev_title_bg_color . ';padding:0; margin:0;line-height:15px; border: 3px solid ' . $current_day_border_color . '">
                        <p style="background-color:' . $evented_color_bg . ';color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;text-shadow: 1px 1px white;">' . $i . '</p>
                        <div style="background-color:' . $ev_title_bg_color . '">';
            $r = 0;
            for ($j = 0; $j < $k; $j++) {
              if ($r < $number_of_shown_evetns) {
                echo '    <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none; color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . $ev_title[$j] . '</b>
                          </a>';
              }
              else {
                echo '    <br>
                          <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="font-size:11px; background:none;color:' . $event_title_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a>';
                break;
              }
              $r++;
            }			
            echo '      </div>
                      </td>';
          }
          else {
            echo '    <td style="color:' . $text_color_this_month_unevented . ';padding:0; margin:0; line-height:15px; border: 3px solid ' . $current_day_border_color . '; vertical-align:top;">
                        <p style="font-size:'.$other_days_font_size.'px;line-height:1.3;font-family: tahoma;padding-left: 5px;">' . $i . '</p>
                      </td>';
          }
        }
        elseif (in_array($i, $array_days)) {
          echo '      <td class="cala_day" style="background-color:' . $ev_title_bg_color . ';padding:0; margin:0;line-height:15px;">
                        <p style="background-color:' . $evented_color_bg . ';background-color:' . $evented_color_bg . ';color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;text-shadow: 1px 1px white;">' . $i . '</p>';
          $r = 0;
          echo '        <div>';
      		for ($j = 0; $j < $k; $j++) {
            if ($r < $number_of_shown_evetns) {
              echo '      <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '"  style="background:none; color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . $ev_title[$j] . '</b>
                          </a>';
            }
            else {
              echo '      <p><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="font-size:11px; background:none; color:' . $event_title_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), admin_url('admin-ajax.php')) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a></p>';
              break;
            }
            $r++;
          }
          echo '        </div>
                      </td>';
			}
			else {
        echo '        <td style=" color:' . $text_color_this_month_unevented . ';padding:0; margin:0; line-height:15px;border: 1px solid ' . $cell_border_color . ';vertical-align:top;">
                        <p style="font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;">' . $i . '</p>
                      </td>';
      }
    }
    if ($weekday_i % 7 == 0 && $i <> $month_days) {
    	echo '        </tr>
                    <tr height="' . $cell_height . '" style="line-height:15px">';
      $weekday_i = 0;
    }
    $weekday_i += 1;
  }
  $weekday_i;
  $next_i = 1;
  if ($weekday_i != 1) {
    for ($i = $weekday_i; $i <= 7; $i++) {
      if ($i != 7) {
        echo '        <td class="caltext_color_other_months" style="font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;background-color:' . $bg_color_other_months . ';">' . $next_i . '</td>';
      }
      else {
        echo '        <td class="caltext_color_other_months" style="font-size:' . $other_days_font_size . 'px;line-height:1.3;font-family:tahoma;padding-left: 5px;background-color:' . $bg_color_other_months . ';">' . $next_i . '</td>';
      }
      $next_i += 1;
    }
  }
  echo '            </tr>
                  </table>';
  ?>            <input type="text" value="1" name="day" style="display:none" />
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <?php
  die();
}

?>