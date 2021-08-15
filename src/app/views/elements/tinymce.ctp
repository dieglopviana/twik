<?php
/**
 *	ELEMENT NECESSÁRIO PARA QUE O TINYMCE FUNCIONE ADEQUADAMENTE.
 *  PARA CHAMAR ESSE ELEMENT NAS SUAS VIEWS, INSIRA A SEGUINTE LINHA NELAS.
 *  
 *  echo $this->renderElement('tinymce', array('preset' => 'avancado'));
 *  
 *  preset É O NÍVEL DE FUNCIONALIDADES QUE VOCÊ DESEJA PARA SEUS TEXTAREAS.
 *  SUAS OPÇÕES SÃO: simples, intermediario e avancado
**/	
?>
<?php echo($javascript->link("tinymce/jscripts/tiny_mce/tiny_mce.js")); ?>
<script language="javascript" type="text/javascript">
<?php 
if ($preset == "simples"){
    $options = '
	mode : "textareas",
	theme : "simple",
	language: "br"
    ';
} else 

if ($preset == "intermediario"){
    $options = '
	mode : "textareas",
	theme : "advanced",
	language: "br"
    ';
} else 

if ($preset == "avancado"){
    $options = '
	mode : "textareas",
	theme : "advanced",
	language : "br",
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_resizing : true,

	// Office example CSS
	content_css : "css/office.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
    ';
}
?>

tinyMCE.init({<?php echo($options); ?>});
</script> 