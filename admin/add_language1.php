<?php

$response = "";
$langs = $language->getLanguages();

$array_maps = array("czech-slovak-slovenian", "danish_norwegian", "dutch", "finnish", "french", "gaelic",
    "german", "greek", "hungarian", "italian", "portuguese", "romanian", "russian", "spanish", "swedish",
    "turkish", "lithuanian", "polish"
);
$currentData = array();

if (isset($_POST['id'])) {
    $result = $config->getLanguage($_POST['id']);
    $currentData = $result->fetch_assoc();
}

if (isset($_POST['Update'])) {
    $html_email = (isset($_POST['html_email'])) ? $_POST['html_email'] : 0;
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $port = $_POST['port'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bcc_email = (isset($_POST['bcc_email'])) ? $_POST['bcc_email'] : 0;
    $admin_email = (isset($_POST['admin_email'])) ? $_POST['admin_email'] : 0;

    $result = $config->update_email_option($html_email, $smtp_auth, $smtp_server, $encryption, $port, $username, $password, $bcc_email, $admin_email);
    if ($result) {
        $result = $config->getEmailSetting();
        $currentData = $result->fetch_assoc();
//        header("location:/admin/home.php?query=mail");
    } else {
        $response = "Sorry, is failed to update";
    }
}
?>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style-sage.css">

<script type="text/javascript" src="../libs/jQuery/jquery.js"></script>
<script type="text/javascript" src="../libs/nicEdit/nicEdit.min.js"></script>
<script type="text/javascript" src="../js/common.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="../libs/jQuery/plugins/powertip/jquery.powertip.min.js"></script>
<link rel="stylesheet" href="../libs/jQuery/plugins/powertip/css/jquery.powertip.min.css"/>

<div class="p30">
    <form name="language" method="post"
          action="<?php if (isset($id) && $id) {
              echo "add_language.php?id=" . $id;
          } else {
              echo "add_language.php";
          } ?>"
          enctype="multipart/form-data">

        <div class="form_container">

            <div class="clearfix">
                <div class="left_form">
                    <img src="../img/template/info.png" class="tooltip icon"
                         title="Language Id"/>&nbsp;<?php echo $lng['languages']['language_id']; ?>
                </div>
                <div class="right_form"><?php if (isset($_POST['id']) && $_POST['id']) {
                        echo $currentData['id'];
                    } else {
                        echo '<input type="text" name="id" size="10"value="">';
                    } ?>
                </div>
            </div>

            <div class="clearfix">
                <div class="left_form"><img src="../img/template/info.png" class="tooltip icon"
                                            title="2 letters language code"/>&nbsp<?php echo $lng['languages']['code']; ?>
                </div>
                <div class="right_form"><input type="text" name="code" size="10"
                                               value="<?php if (isset($currentData['code'])) {
                                                   echo $currentData['code'];
                                               } ?>"/>&nbsp;
                    <?php echo $lng['languages']['info']['codes_link']; ?>
                </div>
            </div>

            <div class="clearfix">
                <div class="left_form"><?php echo $lng['languages']['language_name']; ?></div>
                <div class="right_form"><input type="text" name="name" size="30"
                                               value="<?php if (isset($currentData['name'])) {
                                                   echo $currentData['name'];
                                               } ?>"/></div>
            </div>

            <div class="clearfix">
                <div class="left_form"><img src="../img/template/info.png" class="tooltip icon"
                                            title="Language Image"/><?php echo $lng['languages']['language_image']; ?>
                </div>
                <div class="right_form">
                    <input name="flag_image" type="file"/>
                    <?php if (isset($currentData['image']) && $currentData['image'] != "") { ?>
                        <a href="../img/languages/<?php echo $currentData['image']; ?>" class="imgfield">
                            <img src="../img/template/camera.png"/></a>
                    <?php } else { ?>
                        <img src="../img/template/camera_off.png"/>
                    <?php } ?>
                    <?php if (isset($currentData['image']) && $currentData['image'] != "") { ?>
                        &nbsp;&nbsp;<a href="edit_language.php?id=<?php echo $_POST['id']; ?>&delete=image">
                            <img src="../img/template/delete.png" class="tooltip icon" alt="">
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class="clearfix">
                <div class="left_form"><img src="../img/template/info.png" class="tooltip icon"
                                            title="{$_POST['id']}"/>&nbsp;<?php echo $lng['languages']['characters_map']; ?>
                </div>
                <div class="right_form">
                    <select name="characters_map[]" id="characters_map" multiple="multiple" size="4" class="mselect">
                        <?php
                        foreach ($array_maps as $v => $item) {
                            ?>
                            <option value="<?php echo $v; ?>"
                                <?php if (isset($currentData['characters_map']) && $currentData['characters_map'] &&
                                    in_array($item, $currentData['characters_map_array'])) {
                                    echo 'selected="selected"';
                                }

                                ?>>
                                <?php echo $item; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="clearfix">
                <div class="left_form"><?php echo $lng['languages']['direction']; ?></div>
                <div class="right_form">
                    <select name="direction">
                        <option value="ltr" <?php if (isset($currentData['direction']) &&
                        $currentData['direction'] == 'ltr') ?>selected="selected"><?php echo $lng['languages']['ltr']; ?>
                        </option>
                        <option value="ltr" <?php if (isset($currentData['direction']) &&
                        $currentData['direction'] == 'rtl') ?>selected="selected"><?php echo $lng['languages']['rtl']; ?>
                        </option>
                    </select>
                </div>
            </div>

            <div class="clearfix">
                <div class="left_form"><img src="../img/template/info.png" class="tooltip icon"
                                            title="<?php echo $lng['languages']['info']['default'] ?>"/>&nbsp;
                    <?php echo $lng['general']['default']; ?>
                </div>
                <div class="right_form"><input name="default" type="checkbox" class="noborder"
                        <?php if (isset($currentData['default']) && $currentData['default'] == 1){ ?> checked="checked"<?php } ?>/>
                </div>
            </div>

            <div class="clearfix">
                <div class="left_form"><?php echo $lng['general']['enabled']; ?></div>
                <div class="right_form"><input name="enabled" type="checkbox" class="noborder"
                        <?php if ((isset($currentData['enabled'])) && $currentData['enabled'] == 1){ ?> checked="checked"<?php } ?>/>
                </div>
            </div>


            <div class="form_footer">
                    <input type="submit" class="btn btn-primary rfloat" name="<?php echo (isset($_POST['id'])) ? 'Update' : 'Add'; ?>" id="Submit"
                           value="<?php echo $lng['general']['submit']; ?>"/>
                <div class="clearfix"></div>
            </div>

        </div>

    </form>
</div>
