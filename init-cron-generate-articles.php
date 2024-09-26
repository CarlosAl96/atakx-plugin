<?php

function atakx_init_cron_generate_article()
{
     if (!wp_next_scheduled('atakx_cron_generate_article')) {
          wp_schedule_event(time(), 'weekly', 'atakx_cron_generate_article');
     }

     if (wp_next_scheduled('atakx_initial_cron')) {
          $timestamp = wp_next_scheduled('atakx_initial_cron');
          wp_unschedule_event($timestamp, 'atakx_initial_cron');
     }
}
