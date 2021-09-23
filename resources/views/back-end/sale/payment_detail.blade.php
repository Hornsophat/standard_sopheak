<div class="row" style="width: 100%;">
    <ol style="width: 100%;">
        @if($item->paymentTimelineDetails->count())
            @foreach($item->paymentTimelineDetails as $value)
                @if($value->duration_type == '1')
                    @php $type = 'Days'; @endphp
                @elseif($value->duration_type == '2')
                    @php $type = 'Weeks'; @endphp
                @elseif($value->duration_type == '3')
                    @php $type = 'Months'; @endphp
                @else
                    @php $type = ''; @endphp
                @endif


                @php $label = number_format((float)($label = $total * $value->amount_to_pay_percentage / 100), 2, '.', ''); @endphp
                <?php
                    $width = 100 / ($item->paymentTimelineDetails->count() != 0?$item->paymentTimelineDetails->count():1);
                ?>
                    <li class="payment_timeline" style="width: {{$width}}%!important;">
                        <p class="diplome">{{ '$ '.$label }}</p>
                        <span class="point"></span>
                        <p class="description">
                            {{ $value->duration . ' '. $type }}
                        </p>
                    </li>


            @endforeach
        @endif
    </ol>
</div>