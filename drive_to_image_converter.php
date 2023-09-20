<?php
/*
Plugin Name: Drive to Image Converter
Description: Converts Google Drive links to Google Image links.
Version: 1.0
Author: Your Name
*/

function drive_to_image_shortcode() {
    ob_start(); ?>
    <form action="" method="post">
        <label for="drive_link">Enter Google Drive Link:</label>
        <input type="text" name="drive_link" id="drive_link" required>
        <input type="submit" value="Convert">
    </form>

    <?php
    if(isset($_POST['drive_link'])) {
        $drive_link = $_POST['drive_link'];
        $image_link = convert_drive_to_image_link($drive_link);

        if($image_link) {
            echo "<p>The converted image link is: <a href='{$image_link}' target='_blank'>{$image_link}</a></p>";
            echo "<img src='{$image_link}' alt='Google Image'>";
        } else {
            echo "<p>Invalid Google Drive link format.</p>";
        }
    }

    return ob_get_clean();
}
add_shortcode('drive_to_image_converter', 'drive_to_image_shortcode');

function convert_drive_to_image_link($drive_link) {
    $pattern = '/\/d\/([^\/]+)\//';
    preg_match($pattern, $drive_link, $matches);
    if ($matches) {
        $unique_id = $matches[1];
        $image_link = "https://drive.google.com/uc?id={$unique_id}";
        return $image_link;
    } else {
        return null;
    }
}
