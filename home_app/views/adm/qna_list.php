<div class="page-title-sec marketing-tit">
	<h2 class="page-title"><?=$title?></h2>
</div>
<div class="admin-page-sec">
    <table>
    <?php foreach($bbs_result as $val) : ?>
        <tr>
            <td>
                <?=$list_num?>
            </td>
            <td>
                <a href="<?=site_url()?>homeAdm/qna/view/<?=$val->bbs_id?>"><?=fnc_set_htmls_strip($val->bbs_subject)?></a>
            </td>
            <td>
                <?=fnc_set_htmls_strip($val->user_email)?><br />
                <?=fnc_set_htmls_strip($val->user_name)?>
            </td>
            <td>
                <?=fnc_set_htmls_strip($val->bbs_register)?>
            </td>
        </tr>
    <?php if($list_num >0) $list_num--; endforeach ?>
    </table>
</div>
