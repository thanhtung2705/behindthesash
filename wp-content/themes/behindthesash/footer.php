      <footer class="footer">
          <?php 
            $sitewide = get_field('sitewide', 'option');

            if($sitewide['footer_top']) {
              echo $sitewide['footer_top'];
            }
            if($sitewide['footer_bottom']) {
              echo $sitewide['footer_bottom'];
            }
          ?>
      </footer>
    </div>
    <!-- /wrapper -->

    <?php wp_footer(); ?>
  </body>
</html>
