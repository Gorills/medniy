<div class="apartment-list">
    <div class="apartment-list__top s_ninja">
        <div class="apartment-list__top-item">Корпус</div>
        <div class="apartment-list__top-item">Этаж</div>
        <div class="apartment-list__top-item">
            <span class="tablet-hidden">Спален</span>
            <span class="tablet-visible">Ком.</span>
        </div>
        {{--<div class="apartment-list__top-item">Отделка</div>--}}
        <div class="apartment-list__top-item">Площадь</div>
        <div class="apartment-list__top-item"></div>
    </div>
    <div class="apartment-list__content">
        @foreach($apartments as $apartment)
            <a
                    class="apartment-list__row"
                    href="{{ route('apartment-detail', $apartment->code) }}"
                    data-build="{{ $apartment->floor->block->id }}"
                    data-rooms="{{ $apartment->rooms }}"
                    data-decoration="{{ $apartment->decoration->id }}"
                    data-square="{{ $apartment->total_area }}"
                    data-price="{{ $apartment->price }}"
            >
                <div class="apartment-list__row-item"><span class="apartment-list__title ninja_s">Корпус</span>{{ $apartment->floor->block->number }}</div>
                <div class="apartment-list__row-item"><span class="apartment-list__title ninja_s">Этаж</span>{{ $apartment->floor->number }}</div>
                <div class="apartment-list__row-item"><span class="apartment-list__title ninja_s">Спален</span>{{ $apartment->rooms }}</div>
                <?php /*
                <div class="apartment-list__row-item">
                    <span class="tablet-hidden">{{ $apartment->decoration->name }}</span>
                    <span class="tablet-visible">{{ $apartment->decoration->name }}</span>  <?php #TODO fix ?>
                </div>
                */?>
                <div class="apartment-list__row-item"><span class="apartment-list__title ninja_s">Площадь</span>{{ $apartment->total_area }} кв.м</div>
                <div class="apartment-list__row-item"></div>
            </a>
        @endforeach
    </div>
</div>