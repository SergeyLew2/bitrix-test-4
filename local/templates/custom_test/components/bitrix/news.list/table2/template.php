<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>


<?php
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
$this->addExternalJS("https://www.google.com/recaptcha/api.js?render=" . KEY_RECAPCHA);
?>

<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div class="custom-float"><span class="custom-span">Employee</span>&nbsp;<span class="custom-span weight">Details</span></div>
<div class="custom-align" align="right"><button id="get-popup" align="right" type="button" class="btn btn-info  custom-button">+ Add New</button></div>
<table style="font-size: 0.6rem;" class="table table-bordered table-sm" width="100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
  </thead>
<?foreach($arResult["ITEMS"] as $arItem):?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
    <tr class="custom-tr" data="<?php echo $arItem['ID']; ?>">

        <td data="name">
            <?php echo $arItem['NAME'];?>
        </td>
        <td data="department">
            <?php echo $arItem["DISPLAY_PROPERTIES"]["UF_DEPARTMENT_EMPLOYEE"]["DISPLAY_VALUE"];?>
        </td>
        <td data="phone">
            <?php echo $arItem["DISPLAY_PROPERTIES"]["UF_PHONE_EMPLOYEE"]["DISPLAY_VALUE"];?>
        </td>
        <td>
            <img class="custom-small edit" data="<?php echo $arItem['ID']; ?>" src="<?php echo SITE_TEMPLATE_PATH; ?>/images/edit_icon-icons.com_52382.png" />&nbsp;
            <img class="custom-small delete" data="<?php echo $arItem['ID']; ?>" src="<?php echo SITE_TEMPLATE_PATH; ?>/images/free-icon-delete-14360493.png" />
        </td>
    </tr>
<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<?php
$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>5, "CODE"=>"UF_DEPARTMENT_EMPLOYEE"));
while($enum_fields = $property_enums->GetNext())
{
    $VALUES[] = $enum_fields;
}
?>
<!------Modal_1(add)------------>
<div id="popup-fade_1" class="popup-fade">
    <div id="popup_1" class="popup">
        <div class="custom-popup-header custom-header">Добавить пользователя</div><a id="popup-close_1" class="popup-close" href="#">X</a>
        <div class="custom-popup-content">
            <input type="text" class="custom-input" id="custom-input-name_1" required placeholder="Name">
            <select class="custom-input" id="custom-input-department_1" required>
                <?php foreach($VALUES as $oneValue): ?>
                    <option value="<?php echo $oneValue['ID']; ?>"><?php echo $oneValue['VALUE']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" class="custom-input" id="custom-input-phone_1" required placeholder="Phone">
            <input type="hidden" name="recaptcha_response_1" id="recaptchaResponse_1">
        </div>
        <div class="custom-popup-footer"><button type="button" id="custom-btn-primary_1" class="btn btn-primary custom-btn-primary">сохранить</button></div>
    </div>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('<?php echo KEY_RECAPCHA; ?>', {action:'contact_1'}).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse_1');
                recaptchaResponse.value = token;
            });
        });
    </script>
</div>
<!------Modal_2(edit)------>
<div id="popup-fade_2" class="popup-fade">
    <div id="popup_2" class="popup">
        <div class="custom-popup-header custom-header">Редактирование пользователя</div><a id="popup-close_2" class="popup-close" href="#">X</a>
        <div class="custom-popup-content">
            <input type="text" id="custom-input-name_2" class="custom-input" required placeholder="Name">
            <select id="custom-input-department_2" class="custom-input" required>
                <?php foreach($VALUES as $oneValue): ?>
                    <option value="<?php echo $oneValue['ID']; ?>"><?php echo $oneValue['VALUE']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" id="custom-input-phone_2" class="custom-input" required placeholder="Phone">
            <input type="hidden" name="recaptcha_response_2" id="recaptchaResponse_2">
        </div>
        <div class="custom-popup-footer"><button type="button" id="custom-btn-primary_2" class="btn btn-primary custom-btn-primary">сохранить</button></div>
    </div>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('<?php echo KEY_RECAPCHA; ?>', {action:'contact_2'}).then(function (token) {
               var recaptchaResponse = document.getElementById('recaptchaResponse_2');
               recaptchaResponse.value = token;
            });
        });
    </script>
</div>
<!------Modal_3(delete)---->
<div id="popup-fade_3" class="popup-fade">
    <div id="popup_3" class="popup">
        <div class="custom-popup-header custom-header">Вы точно хотите удалить элемент?</div>
        <div class="custom-popup-content custom-margin">
            <button type="button" class="btn custom-delete-conf">Удалить</button>
            <button type="button" class="btn custom-not-delete-conf">Отмена</button>
            <input type="hidden" name="recaptcha_response_3" id="recaptchaResponse_3">
        </div>

    </div>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('<?php echo KEY_RECAPCHA; ?>', {action:'contact_3'}).then(function (token) {
               var recaptchaResponse = document.getElementById('recaptchaResponse_3');
               recaptchaResponse.value = token;
            });
        });
    </script>
</div>
<script>
    BX.message({
        TEMPLATE_PATH: '<?php echo SITE_TEMPLATE_PATH; ?>'
    });
</script>
</div>
