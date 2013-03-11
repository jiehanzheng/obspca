<?php get_header(); ?>
</div><!-- container -->

<div id="nicePics" class="carousel slide">
  <div class="carousel-inner">
    <div class="item active">
      <img src="http://placekitten.com/1500/500" alt="cats" />
    </div>
    <div class="item">
      <img src="http://placehold.it/1500x500" alt="cats" />
    </div>
  </div>

  <a class="left carousel-control" href="#nicePics" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#nicePics" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>

<div class="container">

  <div class="alert alert-error">
    <strong>Example announcement:</strong>
    This is not the official Outer Banks SPCA website yet.
  </div>

  <div class="alert alert-info">
    Under construction.
  </div>

  <div class="row">
    <div class="span8">
      <h2>News</h2>
    </div>
    <div class="span4">
      <div class="well">
        <p>Donation and stuff</p>
      </div>
      <h2>Featured Pets</h2>
    </div>
  </div>

<?php get_footer(); ?>