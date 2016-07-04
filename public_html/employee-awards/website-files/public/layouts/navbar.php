<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $main; ?>"><?php echo $sitename ?></a>
    </div>
    <ul class="nav navbar-nav">
        <?php if(!isset($navbar)){
                return;
              }
        foreach($navbar as $nav): ?>
        <?php if($nav['link'] === '#'): ?>
            <li class="<?php echo 'active'; ?>"><a  href="<?php echo $nav['link']; ?>"><?php echo $nav['desc']; ?></a></li>
        <?php else: ?>
              <li><a href="<?php echo $nav['link']; ?>"><?php echo $nav['desc']; ?></a></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
  </div>
</nav>