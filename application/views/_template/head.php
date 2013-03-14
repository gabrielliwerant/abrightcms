<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed'); ?>

<!DOCTYPE html <?php echo $this->doctype; ?>>

<html dir="<?php echo $this->html_dir; ?>" lang="<?php echo $this->html_lang; ?>">

<head>

    <title><?php echo $this->title; ?> | <?php echo $this->title_page; ?><?php if (isset($this->title_subpage)): echo $this->title_subpage; endif;?></title>

	<?php echo $this->meta; ?>

	<?php echo $this->css; ?>
	
	<?php echo $this->head_links; ?>
	
	<?php echo $this->head_js; ?>
   
</head>

<body>
	
<div id="wrapper-outer" class="<?php echo $this->page; ?>">
	
	<div id="wrapper-inner">