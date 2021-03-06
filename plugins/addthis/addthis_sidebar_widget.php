<?php
/**
 * +--------------------------------------------------------------------------+
 * | Copyright (c) 2008-2015 AddThis, LLC                                     |
 * +--------------------------------------------------------------------------+
 * | This program is free software; you can redistribute it and/or modify     |
 * | it under the terms of the GNU General Public License as published by     |
 * | the Free Software Foundation; either version 2 of the License, or        |
 * | (at your option) any later version.                                      |
 * |                                                                          |
 * | This program is distributed in the hope that it will be useful,          |
 * | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
 * | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
 * | GNU General Public License for more details.                             |
 * |                                                                          |
 * | You should have received a copy of the GNU General Public License        |
 * | along with this program; if not, write to the Free Software              |
 * | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA |
 * +--------------------------------------------------------------------------+
 */

/**
 * AddThis Widget that allows you to pick your poison, add a widget title, and share your content
 */
class AddThisSidebarWidget extends WP_Widget {


    /**
     *  Constructor
     */
    function AddThisSidebarWidget()
    {

        $widget_ops = array(
            'classname'   => 'atwidget',
            'description' => 'Make it wasy for your users to share content to over 300 destinations'
        );

        /* Widget control settings. */
        $control_ops = array('width' => 325);

        /* Create the widget. */
        $this->WP_Widget(
            'addthis-widget',
            'AddThis Sharing Buttons',
            $widget_ops,
            $control_ops
        );

    }

    /**
     * Echo's out the content of our widget
     */
    function widget($args, $instance)
    {
        extract ( $args );
        $addthis_new_styles = _get_style_options();


        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;
        if ($title)
                echo $before_title . $title . $after_title;

        printf($addthis_new_styles[$instance['style']]['src'], '');

        echo $after_widget;
    }

    /**
     * Update this instance
     */
    function update($new_instance, $old_instance)
    {
        global $addthis_new_styles;

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        if (isset($addthis_new_styles[ $new_instance['style'] ] ) )
            $instance['style'] = strip_tags($new_instance['style']);




        return $instance;

    }

    /**
     *  The form with the widget options
     */
    function form($instance)
    {
        global $cmsConnector;

        if (empty($instance)) {
            $instance = array('style'=> '' , 'title' => '');
        }

        $style = (empty($instance['style'])) ? addthis_style_default : esc_attr($instance['style']);
        $title = (empty($instance['title'])) ? '' : esc_attr($instance['title']);

        global $addthis_new_styles;

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e('Title:'); ?>
                    <input
                        class="widefat"
                        id="<?php echo $this->get_field_id('title'); ?>"
                        name="<?php echo $this->get_field_name('title'); ?>"
                        type="text"
                        value="<?php echo $title; ?>"
                    />
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('style');?>">
                    <?php _e('Style:', 'addthis'); ?>
                    <br />
                </label>
            </p>
            <?php
            foreach ($addthis_new_styles as $k => $v) {
                $checked = '';
                if ($k === $style) {
                    $checked = 'checked="checked"';
                }

                echo '
                    <div style="height:auto;">
                        <input '.$checked.'
                            style="margin:5px 5px 0 0;"
                            type="radio"
                            name="' . $this->get_field_name('style') . '"
                            value="'.$k.'"
                        />
                        <img
                            align="middle"
                            style="padding:5px 0"
                            src="'. $cmsConnector->getPluginImageFolderUrl() .  $v['img'] .'"
                        />
                    </div>';
            }
                ?>
        <?php
    }

}




