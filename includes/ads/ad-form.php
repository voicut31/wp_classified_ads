<?php
/*
Template Name: Vt Ad form
*/
?>

<?php

const STATUS_PENDING = 1;

global $wpdb;

$args = ["hide_empty" => 0,
    "type"      => "post",
    "orderby"   => "name",
    "order"     => "ASC"];
$categories = get_categories($args);

if(isset($_POST['submitted'])) {
    if(trim($_POST['title']) === '') {
        $titleError = __('Please enter your title.');
        $hasError = true;
    } else {
        $storeArr['title'] = trim($_POST['title']);
        $storeArr['slug'] = strtolower(str_replace(' ', '-', $storeArr['title']));
    }

    if(trim($_POST['description']) === '') {
        $descriptionError = __('Please enter a description.');
        $hasError = true;
    } else {
        if(function_exists('stripslashes')) {
            $storeArr['description'] = stripslashes(trim($_POST['description']));
        } else {
            $storeArr['description'] = trim($_POST['description']);
        }
    }

    if(trim($_POST['type']) === '') {
        $typeError = __('Please select your type.');
        $hasError = true;
    } else {
        $storeArr['type'] = trim($_POST['type']);
    }

    if(trim($_POST['phone']) === '') {
        $titleError = __('Please enter your phone number.');
        $hasError = true;
    } else {
        $storeArr['phone'] = trim($_POST['phone']);
    }

    if(trim($_POST['price']) === '') {
        $titleError = __('Please enter the price.');
        $hasError = true;
    } else {
        $storeArr['price'] = trim($_POST['price']);
    }

    $storeArr['status'] = STATUS_PENDING;
    $storeArr['created_at'] = date('Y-m-d H:i:s');
    $storeArr['updated_at'] = date('Y-m-d H:i:s');

    if (!empty($_FILES['file']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, ['test_form' => false]);

        if ($upload && !isset($upload['error'])) {
            $storeArr['filename'] = $upload['url'];
        } else {
            $fileError = __('There was an error uploading the file.');
            $hasError = true;
        }
    }

    if(!isset($hasError)) {
        $table = "{$wpdb->prefix}classified_ads";
        // Save in the database
        try {
            $wpdb->insert($table, $storeArr);
            $adSaved = true;
        } catch (Exception $e) {
            print_r($e);
            exit;
        }
    }
}
?>

<style>
    #container {
        display: block;
        min-width: 600px;
    }
</style>
    <div id="container">
        <div id="content">
            <?php
            if (isset($adSaved)) {
                echo __('Thank you for sending us your ad.');
            } else {
                ?>
                <form action="<?php the_permalink(); ?>" id="vtForm" method="post" enctype="multipart/form-data">
                    <?php if(isset($hasError) || isset($captchaError)) { ?>
                        <p class="error"><?php echo __('Sorry, an error occured.'); ?><p>
                    <?php } ?>

                    <div class="form-group vt-ad-form">
                        <label for="title"><?php echo __('Title'); ?>:</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>" />
                        <?php if(isset($titleError) && $titleError != '') { ?>
                            <p class="error"><?php echo $titleError;?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="description"><?php echo __('Description'); ?>:</label>
                        <textarea name="description"  class="form-control" id="description" rows="10" cols="30"><?php if(isset($_POST['description'])) echo $_POST['description'];?></textarea>
                        <?php if(isset($descriptionError) && $descriptionError != '') { ?>
                            <p class="error"><?php echo $descriptionError;?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="category"><?php echo __('Category'); ?>:</label>
                        <select name="type"  class="form-control" id="type">
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    echo "<option value='{$category->cat_ID}'>{$category->name}</option>";
                                }
                            }
                            ?>
                        </select>
                        <?php if(isset($descriptionError) && $descriptionError != '') { ?>
                            <p class="error"><?php echo $descriptionError;?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="type"><?php echo __('Type'); ?>:</label>
                        <select name="type"  class="form-control" id="type">
                            <option value="1"><?php echo __('Sell') ?></option>
                            <option value="2"><?php echo __('Buy') ?></option>
                            <option value="3"><?php echo __('Rent') ?></option>
                        </select>
                        <?php if(isset($descriptionError) && $descriptionError != '') { ?>
                            <p class="error"><?php echo $descriptionError;?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group vt-ad-form">
                        <label for="phone"><?php echo __('Phone'); ?>:</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];?>" />
                        <?php if(isset($phoneError) && $phoneError != '') { ?>
                            <p class="error"><?php echo $phoneError;?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group vt-ad-form">
                        <label for="price"><?php echo __('Price'); ?>:</label>
                        <input type="text" class="form-control" name="price" id="title" value="<?php if(isset($_POST['price'])) echo $_POST['price'];?>" />
                        <?php if(isset($priceError) && $priceError != '') { ?>
                            <p class="error"><?php echo $priceError;?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group vt-ad-form"></div>
                        <label for="file"><?php echo __('Upload File'); ?>:</label>
                        <input type="file" class="form-control" name="file" id="file" />
                        <?php if(isset($fileError) && $fileError != '') { ?>
                            <p class="error"><?php echo $fileError;?></p>
                        <?php } ?>
                    </div>

                    <input type="submit" value="Submit" name="Submit" />
                    <input type="hidden" name="submitted" id="submitted" value="true" />
                    <br class="clear">
                </form>
            <?php } ?>
        </div>
    </div>

<?php get_footer() ?>