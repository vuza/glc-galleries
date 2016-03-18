<?php
add_action( 'add_meta_boxes', 'date_metabox' );

function date_metabox() {
    add_meta_box(
        'date_metabox',
        'Aufnahmedatum',
        'create_metabox_html',
        'glc_gallery',
        'side',
        'default'
    );
}

function create_metabox_html() {
    wp_register_script('pikaday', plugins_url( './lib/pikaday/pikaday.js' , __FILE__ ));
    wp_enqueue_script('pikaday');

    wp_register_style('pikaday', plugins_url( './lib/pikaday/pikaday.css' , __FILE__ ));
    wp_enqueue_style('pikaday');

    wp_register_script('momentjs', plugins_url( './lib/momentjs/moment-with-locales.js' , __FILE__ ));
    wp_enqueue_script('momentjs');

    global $post;
    $post_id = $post->ID;
    ?>

    <input type="hidden" name="unformatted_event_date" id="unformatted_event_date">
    <input type="text" name="event_date" id="event_date" value="<?php echo get_post_meta($post_id, 'event_date', true); ?>">

    <script>
        jQuery(document).ready(function(){
            new Pikaday({
                field: jQuery('#event_date')[0],
                onSelect: function() {
                    // Save full date-time-string to hidden input field #unformatted_event_date, which gets read on save_post
                    var d = this.getDate();
                    var m = moment(d);
                    var dString = m.format('YYYY-MM-DD');
                    jQuery('#unformatted_event_date').val(dString);
                },
                i18n: {
                    previousMonth : 'Previous Month',
                    nextMonth     : 'Next Month',
                    months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
                    weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                    weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
                }
            }); //TODO strings in popup and in input field
        });
    </script>

    <?php
}

add_action('save_post', 'date_metabox_save');

function date_metabox_save($post_id) {
    update_post_meta($post_id, 'event_date', $_POST['unformatted_event_date']);
}