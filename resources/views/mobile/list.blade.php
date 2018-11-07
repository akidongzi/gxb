@extends('mobile.layouts.main')

@section('content')
<div class="main minirefresh-wrap" id="minirefresh">
	<div class="minirefresh-scroll">
		<p class="update-number"></p>
		<div class="index-list data-list" id="listdata">
		</div>
	</div>
</div>
@include('mobile.partials.footer-nav')
@endsection

@section('body_end')
<script type="text/javascript">
    POSITION_ID = "{{ app('request')->input('positionId') }}";
    TYPE = 1;
</script>
@endsection