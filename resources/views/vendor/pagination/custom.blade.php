 @if ($paginator->hasPages())

 <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-no-wrap items-center">
     <ul class="pagination">

         @if ($paginator->onFirstPage())
         <li>
             <a class="pagination__link cursor-not-allowed" href="javascript:void(0)">
                 <i class="w-4 h-4" data-feather="chevron-left"></i>
             </a>
         </li>
         @else
         <li>
             <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}">
                 <i class="w-4 h-4" data-feather="chevron-left"></i>
             </a>
         </li>
         @endif

         @foreach ($elements as $element)

         @if (is_string($element))
         <li class="disabled"><span>{{ $element }}</span></li>
         @endif



         @if (is_array($element))
         @foreach ($element as $page => $url)
         @if ($page == $paginator->currentPage())
         <li>
             <a class="pagination__link pagination__link--active" href="">{{ $page }}</a>
         </li>
         @else
         <li><a class="pagination__link" href="{{ $url }}">{{ $page }}</a></li>
         @endif
         @endforeach
         @endif
         @endforeach

         @if ($paginator->hasMorePages())

         <li>
             <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}">
                 <i class="w-4 h-4" data-feather="chevron-right"></i>
             </a>
         </li>

         @else

         <li>
             <a class="pagination__link hidden" href="javascript:void(0)">
                 <i class="w-4 h-4" data-feather="chevron-right"></i>
             </a>
         </li>
         @endif



     </ul>


 </div>
 @endif
