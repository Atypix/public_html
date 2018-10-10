<div id="job-manager-job-dashboard">
	
	<p><?php esc_html_e( 'Your listings are shown in the table below.', 'knowherepro' ); ?></p>

	<div class="kw-table-container kw-horizontal kw-table-listings">

		<table class="job-manager-jobs">
			<thead>
			<tr>
				<?php foreach ( $job_dashboard_columns as $key => $column ) : ?>
					<th class="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $column ); ?></th>
				<?php endforeach; ?>
			</tr>
			</thead>
			<tbody>
			<?php if ( ! $jobs ) : ?>
				<tr>
					<td colspan="6"><?php esc_html_e( 'You do not have any active listings.', 'knowherepro' ); ?></td>
				</tr>
			<?php else : ?>
				<?php foreach ( $jobs as $job ) : ?>
					<tr>
						<?php foreach ( $job_dashboard_columns as $key => $column ) : ?>
							<td class="<?php echo esc_attr( $key ); ?>">
								<?php if ('job_title' === $key ) : ?>
									<?php if ( $job->post_status == 'publish' ) : ?>
										<a href="<?php echo get_permalink( $job->ID ); ?>"><?php echo esc_html($job->post_title); ?></a>
									<?php else : ?>
										<?php echo esc_html($job->post_title); ?> <small>(<?php the_job_status( $job ); ?>)</small>
									<?php endif; ?>
									<ul class="job-dashboard-actions">
										<?php
										$actions = array();

										switch ( $job->post_status ) {
											case 'publish' :
												$actions['edit'] = array( 'label' => esc_html__( 'Edit', 'knowherepro' ), 'nonce' => false );

												if ( is_position_filled( $job ) ) {
													$actions['mark_not_filled'] = array( 'label' => esc_html__( 'Mark not filled', 'knowherepro' ), 'nonce' => true );
												} else {
													$actions['mark_filled'] = array( 'label' => esc_html__( 'Mark filled', 'knowherepro' ), 'nonce' => true );
												}

												$actions['duplicate'] = array( 'label' => esc_html__( 'Duplicate', 'knowherepro' ), 'nonce' => true );
												break;
											case 'expired' :
												if ( job_manager_get_permalink( 'submit_job_form' ) ) {
													$actions['relist'] = array( 'label' => esc_html__( 'Relist', 'knowherepro' ), 'nonce' => true );
												}
												break;
											case 'pending_payment' :
											case 'pending' :
												if ( job_manager_user_can_edit_pending_submissions() ) {
													$actions['edit'] = array( 'label' => __( 'Edit', 'knowherepro' ), 'nonce' => false );
												}
												break;
										}

										$actions['delete'] = array( 'label' => esc_html__( 'Delete', 'knowherepro' ), 'nonce' => true );
										$actions           = apply_filters( 'job_manager_my_job_actions', $actions, $job );

										foreach ( $actions as $action => $value ) {
											$action_url = add_query_arg( array( 'action' => $action, 'job_id' => $job->ID ) );
											if ( $value['nonce'] ) {
												$action_url = wp_nonce_url( $action_url, 'job_manager_my_job_actions' );
											}
											echo '<li><a href="' . esc_url( $action_url ) . '" class="job-dashboard-action-' . esc_attr( $action ) . '">' . esc_html( $value['label'] ) . '</a></li>';
										}
										?>
									</ul>
								<?php elseif ('date' === $key ) : ?>
									<?php echo date_i18n( get_option( 'date_format' ), strtotime( $job->post_date ) ); ?>
								<?php elseif ('expires' === $key ) : ?>
									<?php echo $job->_job_expires ? date_i18n( get_option( 'date_format' ), strtotime( $job->_job_expires ) ) : '&ndash;'; ?>
								<?php elseif ('filled' === $key ) : ?>
									<?php echo is_position_filled( $job ) ? '&#10004;' : '&ndash;'; ?>
								<?php else : ?>
									<?php do_action( 'job_manager_job_dashboard_column_' . $key, $job ); ?>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>

	</div>

	<?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>

</div>
