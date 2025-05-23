<div id="items-dropzone" class="post-dropzone">   
	<div class="modal-body clearfix">
		<div class="row">
			<div class="col-md-12 border-right project_file_area">
				<?php if(!empty($file->external) && $file->external == 'dropbox'){ ?>
					<a href="<?php echo html_entity_decode($file->external_link); ?>" target="_blank" class="btn btn-info mbot20"><i class="fa fa-dropbox" aria-hidden="true"></i> <?php echo app_lang('open_in_dropbox'); ?></a><br />
				<?php } ?>
				<?php
				$path = HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name;
				if(is_image($path)){ ?>
					<img src="<?php echo base_url(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name); ?>" class="img img-responsive ">
				<?php } else if(!empty($file->external) && !empty($file->thumbnail_link)){ ?>
					<img src="<?php echo optimize_dropbox_thumbnail($file->thumbnail_link); ?>" class="img img-responsive">
				<?php } else if(strpos($file->file_name,'.pdf') !== false && empty($file->external)){ ?>
					<iframe src="<?php echo base_url(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
				<?php } else if(strpos($file->file_name,'.xls') !== false && empty($file->external)){ ?>
					<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
					</iframe>
				<?php } else if(strpos($file->file_name,'.xlsx') !== false && empty($file->external)){ ?>
					<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
					</iframe>
				<?php } else if(strpos($file->file_name,'.doc') !== false && empty($file->external)){ ?>
					<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
					</iframe>
				<?php } else if(strpos($file->file_name,'.docx') !== false && empty($file->external)){ ?>
					<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER.'/'.$file->rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
					</iframe>
				<?php } else if(is_html5_video($path)) { ?>
					<video width="100%" height="100%" src="<?php echo site_url('download/preview_video?path='.protected_file_url_by_path($path).'&type='.$file->filetype); ?>" controls>
						Your browser does not support the video tag.
					</video>
				<?php } else if(is_markdown_file($path) && $previewMarkdown = markdown_parse_preview($path)) {
					echo html_entity_decode($previewMarkdown);
				} else {
					
					echo '<p class="text-muted">'.app_lang('no_preview_available_for_file').'</p>';
				} ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
		
	</div>
</div>

<?php require 'plugins/Hr_profile/assets/js/preview_file_js.php';?>

