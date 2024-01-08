<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      EBook<span>Web</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item">
        <a href="{{ route('user.dashboard')}}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">Books</li>
      <li class="nav-item">
        <a href="{{ route('user.book.table')}}" class="nav-link">
          <i class="link-icon" data-feather="file"></i>
          <span class="link-title">Upload</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="pages/apps/calendar.html" class="nav-link">
          <i class="link-icon" data-feather="share"></i>
          <span class="link-title">Shared</span>
        </a>
      </li> -->
    </ul>
  </div>
</nav>