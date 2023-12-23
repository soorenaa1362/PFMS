<hr>
<div class="d-flex justify-content-between">
    <div>
        <a href="{{ route('users.cards.index') }}" class="text-center text-secondary d-grid gap-2">
            <i class="fa fa-credit-card text-secondary fa-3x"></i>
            <span style="font-size: 15px;">کارت ها</span>
        </a>
    </div>
    <div>
        <a href="{{ route('users.incomes.index') }}" class="text-center text-success d-grid gap-2">
            <i class="fas fa-donate text-success fa-3x"></i>
            <span style="font-size: 15px;">درآمد ها</span>
        </a>
    </div>
    <div>
        <a href="{{ route('users.costs.index') }}" class="text-center text-danger d-grid gap-2">
            <i class="fas fa-hand-holding-usd text-danger fa-3x"></i>
            <span style="font-size: 15px;">مخارج</span>
        </a>
    </div>
    <div>
        <a href="{{ route('users.home') }}" class="text-center text-dark d-grid gap-2">
            <i class="fa fa-home text-dark fa-3x"></i>
            <span style="font-size: 15px;">صفحه اصلی</span>
        </a>
    </div>
</div>
