<?php
/**
 * The template for the footer.
 *
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
		<div id="site-generator">
			<?php do_action( 'seismicnyc_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'seismicnyc' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'seismicnyc' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'seismicnyc' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<span class="shake-me">
				<?php printf( __( '%1$s by %2$s.', 'seismicnyc' ), '<a href="'.esc_url('http://www.seismicthemes.com/seismic-manhattan-theme').'">Seismic Manhattan</a>', 'Seismic Themes' ); ?>
			</span>
		</div>
		<div class="clearfix"></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>