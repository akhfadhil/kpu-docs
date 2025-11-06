<nav aria-label="Breadcrumb" class="mb-6">
  <ol role="list"
      class="flex flex-wrap items-center gap-1 text-sm text-text-secondary-light dark:text-text-secondary-dark">

    @foreach ($items as $item)
      <li class="flex items-center">
        {{-- Chevron separator (kecuali item pertama) --}}
        @if (!$loop->first)
          <span class="material-icons text-base text-gray-400 dark:text-gray-500 mx-1">
            chevron_right
          </span>
        @endif

        {{-- Link atau teks aktif --}}
        @if (!$loop->last && !empty($item['url']))
          <a href="{{ $item['url'] }}"
             class="hover:text-primary transition-colors duration-150">
            {{ $item['label'] }}
          </a>
        @else
          <span class="font-medium text-text-light dark:text-text-dark">
            {{ $item['label'] }}
          </span>
        @endif
      </li>
    @endforeach

  </ol>
</nav>
