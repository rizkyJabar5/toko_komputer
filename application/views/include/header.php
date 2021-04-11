<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
		<title><?php echo config_item('web_title'); ?></title>
		<base href="<?php echo base_url(); ?>">
		<link href='<?php echo config_item('img'); ?>favicon.png' type='image/x-icon' rel='shortcut icon'>
		<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="<?php echo config_item('font_awesome'); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo config_item('css'); ?>style-gue.css" rel="stylesheet">
		<script src="<?php echo config_item('js'); ?>jquery.min.js"></script>
		<!-- ================== BEGIN BASE CSS STYLE ================== -->
		<link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
		<link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
		<link href="assets/css/animate.min.css" rel="stylesheet" />
		<link href="assets/css/style.min.css" rel="stylesheet" />
		<link href="assets/css/style-responsive.min.css" rel="stylesheet" />
		<!-- <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" /> -->
		<!-- ================== END BASE CSS STYLE ================== -->

		<!-- ================== BEGIN BASE JS ================== -->
		<script src="assets/plugins/pace/pace.min.js"></script>
		<!-- ================== END BASE JS ================== -->
		<script>
		var habiscuy;
		$(document).on({
			ajaxStart: function() {
				habiscuy = setTimeout(function(){
					$("#LoadingDulu").html("<div id='LoadingContent'><i class='fa fa-spinner fa-spin'></i> Mohon tunggu ....</div>");
					$("#LoadingDulu").show();
				}, 500);
			},
			ajaxStop: function() {
				clearTimeout(habiscuy);
				$("#LoadingDulu").hide();
			}
		});
		</script>
	</head>
	<body>
		<div id='LoadingDulu'></div>
