@if ($paginator->hasPages())
    <div class="flex items-center justify-between mt-6">

        <div class="flex flex-1 justify-between sm:hidden">

            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                    Précédent
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Précédent
                </a>
            @endif


            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Suivant
                </a>
            @else
                <span class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                    Suivant
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">


                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-l-md">
                            ‹
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                           class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                            ‹
                        </a>
                    @endif


                    @foreach ($elements as $element)

                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif

                    @endforeach


                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                           class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                            ›
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-r-md">
                            ›
                        </span>
                    @endif

                </span>
            </div>
        </div>
    </div>
@endif
