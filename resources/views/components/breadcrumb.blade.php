<nav aria-label="Breadcrumb" class="mb-6">
  <ol class="flex items-center space-x-2 text-sm text-text-secondary-light dark:text-text-secondary-dark" role="list">
    @foreach ($items as $item)
      <li class="flex items-center">
        @if (!$loop->first)
          <span class="material-icons text-lg">chevron_right</span>
        @endif

        @if (!$loop->last && !empty($item['url']))
          <a href="{{ $item['url'] }}"
             class="ml-2 hover:text-primary">
            {{ $item['label'] }}
          </a>
        @else
          <span class="ml-2 font-medium text-text-light dark:text-text-dark">
            {{ $item['label'] }}
          </span>
        @endif
      </li>
    @endforeach
  </ol>
</nav>
