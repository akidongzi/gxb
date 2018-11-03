@extends('mobile.layouts.gallery')

@section('content')
<!-- S 首页主体 -->
<div class="main minirefresh-wrap" id="minirefresh">
	<div class="minirefresh-scroll">
		<div class="images-list data-list" id="listdata">
		</div>
	</div>
</div>
<!-- E 首页主体 -->
@include('mobile.partials.footer-nav')
@endsection

@section('body_end')
<script type="text/javascript">
    POSITION_ID = "{{ app('request')->input('positionId') }}";
    TYPE = 2;
</script>
@endsection