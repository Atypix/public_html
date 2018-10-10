<?php
/**
 * Resume Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_script( 'wp-resume-manager-resume-submission' );
?>
<form action="<?php echo $action; ?>" method="post" id="submit-resume-form" class="job-manager-form" enctype="multipart/form-data">

	<?php do_action( 'submit_resume_form_start' ); ?>

	<?php if ( apply_filters( 'submit_resume_form_show_signin', true ) ) : ?>
		<div class="job-fields-section">
			<?php get_job_manager_template( 'account-signin.php', array( 'class' => $class ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( resume_manager_user_can_post_resume() ) : ?>

		<?php if ( get_option( 'resume_manager_linkedin_import' ) ) : ?>
			<div class="job-fields-section">
				<?php get_job_manager_template( 'linkedin-import.php', '', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
			</div>
		<?php endif; ?>

		<!-- Resume Fields -->
		<?php do_action( 'submit_resume_form_resume_fields_start' ); ?>

			<div class="job-fields-section">

				<h3 class="job-fields-title"><?php esc_html_e('General Information', 'knowherepro') ?></h3>

				<?php foreach ( $resume_fields as $key => $field ) : ?>
					<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
						<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . apply_filters( 'submit_resume_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'knowherepro' ) . '</small>', $field ); ?></label>
						<div class="field">
							<?php $class->get_field_template( $key, $field ); ?>
						</div>
					</fieldset>
				<?php endforeach; ?>

			</div>

		<?php do_action( 'submit_resume_form_resume_fields_end' ); ?>

		<p>
			<?php wp_nonce_field( 'submit_form_posted' ); ?>
			<input type="hidden" name="resume_manager_form" value="<?php echo $form; ?>" />
			<input type="hidden" name="resume_id" value="<?php echo esc_attr( $resume_id ); ?>" />
			<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
			<input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
			<input type="submit" name="submit_resume" class="button" value="<?php esc_attr_e( $submit_button_text, 'knowherepro' ); ?>" />
		</p>

	<?php else : ?>

		<?php do_action( 'submit_resume_form_disabled' ); ?>

	<?php endif; ?>

	<?php do_action( 'submit_resume_form_end' ); ?>
</form>
