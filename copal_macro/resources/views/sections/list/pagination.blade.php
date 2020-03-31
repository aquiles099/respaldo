<ul class="pagination pull-right">
  @if($pages->currentPage() == 1)
    <li class="disabled">
      <a href="#"><span>&laquo;</span></a>
    </li>
  @else
    <li>
      <a href="{{$pages->previousPageUrl()}}">
        <span>&laquo;</span>
      </a>
    </li>
  @endif
  @for($i = 1; $i <= $pages->lastPage(); $i++)
    <li @if($i == $pages->currentPage()) class="active" @endif ><a href="{{$i == $pages->currentPage() ? 'javascript:void(0)' : $pages->url($i)}}">{{$i}}</a></li>
  @endfor
  @if(!$pages->hasMorePages())
    <li class="disabled">
      <a href="#"><span>&raquo;</span></a>
    </li>
  @else
    <li>
      <a href="{{$pages->nextPageUrl()}}">
        <span>&raquo;</span>
      </a>
    </li>
  @endif
</ul>
