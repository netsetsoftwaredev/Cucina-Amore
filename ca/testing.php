<?php
require('Insta.php');

$media = Instagram::getMediaByHashtag("cucinaandamore", 30);
//echo '<pre>';
//print_r($media);
//exit();
?>
<style>
  .item_insta {
    width: 165px;
    margin: 0 auto;
}
    .item_insta .header_item {
    height: 40px;
}
    .item_insta .header_item .profile_photo_item {
    height: 25px;
    width: 25px;
    position: relative;
    top: 5px;
    display: inline-block;
    left: 5px;
        border: 2px solid gray;
        border-radius: 25px;
}
    .item_insta .header_item .name_profile_item {
    display: inline-block;
    height: 25px;
    width: 120px;
    position: relative;
    top: -5px;
    left: 10px;
}
    .item_insta .insta_text_item span.item_likes {
    width: 89%;
    display: inline-block;
    height: 20px;
    padding: 10px;
}
    .item_insta .insta_main .img_main{
        width: 165px;
        height: 165px;
        display: inline-block
    }
    .item_insta .insta_text_item p {
    padding: 5px;
    font-size: 14px;
    font-weight: lighter;
        margin: 0;
}
 
</style>

<?php foreach($media as $key=>$value): ?>
<?php if($value->is_video == true){ continue; } ?>
<div class="item_insta">
    <div class="header_item">
    <img class="profile_photo_item" src="<?php echo $value->owner->profile_pic_url ?>" />
        <span class="name_profile_item">@<?php echo $value->owner->username ?></span>
    </div>
    <div class="insta_main">
        <img class="img_main" src="<?php echo $value->display_src ?>" />
    </div>
    <div class="insta_text_item">
        <span class="item_likes"><?php echo $value->likes->count ?> likes</span>
        <p><?php echo $value->caption ?></p>
    </div>
</div>
<?php endforeach; ?>
