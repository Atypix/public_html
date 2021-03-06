<?php

namespace Stachethemes\Stec; ?>

<div class="stec-layout-agenda">

    <div class="stec-layout-agenda-list-wrap">
        <ul class="stec-layout-agenda-list stec-layout-agenda-list-b"> </ul>
        <ul class="stec-layout-agenda-list stec-layout-agenda-list-a"> </ul>
    </div>

    <div class="stec-layout-agenda-eventholder-form">
        <ul class="stec-layout-events-form">
            <?php
            // Generated by JS
            // appends forms/create.form.inc.php
            ?>
        </ul>
    </div>

    <div class="stec-layout-agenda-eventholder stec-event-holder">
        <ul class="stec-layout-events">
            <?php
            // Generated by JS
            // include("layout.event.inc.php");
            ?>
        </ul>
    </div>

<?php if ( Settings::get_admin_setting_value('stec_menu__general', 'agenda_list_display') == '1' ) : ?>

        <div class="stec-layout-events stec-layout-agenda-events-all">

            <?php
            // <ul class="stec-layout-agenda-events-all-list">
            // Generated by JS
            // include("layout.event.inc.php");
            // </ul>
            ?>

            <div class="stec-layout-agenda-events-all-control">
                <div data-date="" class="stec-layout-agenda-events-all-load-more"><p><?php _e('Look for more', 'stec'); ?></p></div>
            </div>
        </div>

<?php endif; ?>
</div>