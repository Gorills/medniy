<h1>
    Building block {{ $block->number }}
</h1>

@if(isset($block->floors))
    <ul>
        @foreach($block->floors as $floor)
            <li>
                <a href="{{ route('block-floor', [$block->number, $floor->number]) }}">
                    {{ $floor->number }}
                </a>
            </li>
            <br>
        @endforeach
    </ul>
@endif

<h3>
    to <a href="{{ route('blocks-list') }}">all blocks</a>
</h3>