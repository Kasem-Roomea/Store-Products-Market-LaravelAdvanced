<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="{{$currentPage-1 < 1? 1:$currentPage-1 }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @for($i=1; $i<=$totalPages ;$i++)
            @if($totalPages>5)
                @if( $i == 1)	    
                    <li class="page-item @if($i == $currentPage) active @endif" ><a class="page-link"  href="1" >1</a></li>
                @endif

                @if($i ==2 && $currentPage >2 )
                    <li class="page-item "><a class="page-link" href="#" >...</a></li>
                @endif
                
                @if( $i != 1 &&  $i != $totalPages && ($i == $currentPage ||$i == $currentPage+1 ||  $i == $currentPage-1) )
                <li class="page-item @if($i == $currentPage) active @endif"><a class="page-link" href="{{$i}}" >{{$i}}</a></li>
                @endif

                @if(  $i+1 > $totalPages && $currentPage+1 < $totalPages)
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                @endif
                
                @if( $i == $totalPages && $currentPage!= $totalPages )	    
                    <li class="page-item @if($i == $currentPage) active @endif"><a class="page-link" href="{{$totalPages}}" >الأخير</a></li>
                @endif
                @if( $i == $totalPages && $currentPage== $totalPages )	    
                    <li class="page-item  @if($i == $currentPage) active @endif"><a class="page-link" href="{{$totalPages}}" >{{$i}}</a></li>
                @endif
            @else
                <li class="page-item @if($i == $currentPage) active @endif"><a class="page-link  " href="{{$i}}" >{{$i}}</a></li>
            @endif
        @endfor    
        <li class="page-item">
            <a class="page-link" href="{{$currentPage+1 > $totalPages? $totalPages :$currentPage+1}}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>