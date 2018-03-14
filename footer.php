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
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'seismic-manhattan' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'seismic-manhattan' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'seismic-manhattan' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<span class="shake-me">
				<?php printf( __( '%1$s by %2$s.', 'seismic-manhattan' ), '<a href="'.esc_url('https://www.seismicthemes.com/seismic-manhattan-theme').'">Seismic Manhattan</a>', 'Seismic Themes' ); ?>
			</span>
		</div>
		<div class="clearfix"></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>