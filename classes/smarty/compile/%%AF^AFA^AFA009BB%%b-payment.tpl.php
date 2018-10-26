<?php /* Smarty version 2.6.28, created on 2016-05-07 22:42:09
         compiled from b-payment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'b-payment.tpl', 4, false),)), $this); ?>
<div class="row" style="text-align: center;">

<!--
<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?label=<?php echo ((is_array($_tmp=@$_SESSION['user']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
&account=41001645756948&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=%D0%9D%D0%B5+%D0%BF%D0%BE%D0%BA%D0%B0%D0%B7%D1%8B%D0%B2%D0%B0%D1%82%D1%8C+%D0%B2%D0%BE%D0%B4%D1%8F%D0%BD%D1%8B%D0%B5+%D0%B7%D0%BD%D0%B0%D0%BA%D0%B8&targets-hint=&default-sum=&button-text=01&successURL=http%3A%2F%2Ftest.webmonte.net%2Fproject%2Finterier-413648%3Fpayment_success%3D1" width="450" height="200"></iframe>
-->


<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?label=<?php echo ((is_array($_tmp=@$_SESSION['user']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
&account=410014025375380&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=%D0%9E%D0%BF%D0%BB%D0%B0%D1%82%D0%B0+%D1%81%D0%B5%D1%80%D0%B2%D0%B8%D1%81%D0%B0+Pic-Wall&targets-hint=&default-sum=990&button-text=01&fio=on&mail=on&successURL=http%3A%2F%2Ftest.webmonte.net%2Fproject%2Finterier-413648%2F%3Fpayment_success%3D1" width="450" height="198"></iframe>

</div>