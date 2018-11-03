@push('after-styles')
<link rel="stylesheet" href="{{ asset('js/jquery-ui/jquery-ui.min.css') }}" />
<style>

</style>
@endpush

<table class="table table-borderless meta-info__table">
    <tr>
        <th>作者</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="meta[{{ \App\Models\Article::META_AUTHOR }}]"
                   autocomplete="off"
                   value="{{ isset($article) ? $article->getMeta(\App\Models\Article::META_AUTHOR) : '' }}" />
        </td>
    </tr>

    <tr>
        <th>作者简介</th>
        <td>
            <textarea class="form-control"
                      name="meta[{{ \App\Models\Article::META_AUTHOR_BRIEF }}]">{{ isset($article) ? $article->getMeta(\App\Models\Article::META_AUTHOR_BRIEF) : '' }}</textarea>
        </td>
    </tr>

    <tr>
        <th>国家</th>
        <td>
            <select name="meta[{{ \App\Models\Article::META_COUNTRY }}][]" data-placeholder="请选择" class="meta-country-selector" multiple style="width:100%">
                <option value=""></option>
                @foreach ($countries as $country)
                    <option data-id="{{ $country->id }}"
                            value="{{ $country->name }}"
                            @if(isset($article) && in_array($country->name, (array)$article->getMeta(\App\Models\Article::META_COUNTRY))) selected @endif>{{ $country->name }}</option>
                @endforeach
            </select>
        </td>
    </tr>

    <tr>
        <th>城市</th>
        <td>
            <select name="meta[{{ \App\Models\Article::META_CITY }}][]" data-placeholder="请选择" class="meta-city-selector" multiple style="width:100%">
                <option value=""></option>
                @foreach ($cities as $city)
                    <option data-root-id="{{ $city->root_id }}"
                            data-id="{{ $city->id }}"
                            value="{{ $city->name }}"
                            style="display:none;"
                            @if(isset($article) && in_array($city->name, (array)$article->getMeta(\App\Models\Article::META_CITY))) selected @endif>{{ $city->name }}</option>
                @endforeach
            </select>
        </td>
    </tr>

    <tr>
        <th>品牌活动</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="meta[{{ \App\Models\Article::META_ACTIVITY_BRAND }}]"
                   autocomplete="off"
                   value="{{ isset($article) ? $article->getMeta(\App\Models\Article::META_ACTIVITY_BRAND) : '' }}" />
        </td>
    </tr>

    <tr>
        <th>子活动</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="meta[{{ \App\Models\Article::META_SUBACTIVITY }}]"
                   autocomplete="off"
                   value="{{ isset($article) ? $article->getMeta(\App\Models\Article::META_SUBACTIVITY) : '' }}" />
        </td>
    </tr>

    <tr>
        <th>媒体来源</th>
        <td>
            <select name="meta[{{ \App\Models\Article::META_MEDIA_SOURCE }}]" class="meta-media-source-selector" data-placeholder="请选择" style="width:100%">
                <option value=""></option>
                @foreach (App\Models\Article::$mediaSources as $ms)
                <option value="{{ $ms }}" @if(isset($article) && $ms == $article->getMeta(\App\Models\Article::META_MEDIA_SOURCE)) selected @endif>{{ $ms }}</option>
                @endforeach
            </select>
        </td>
    </tr>

    <tr>
        <th>活动起始</th>
        <td>
            <input type="text"
                   class="form-control meta-activity-start-at"
                   name="meta[{{ \App\Models\Article::META_ACTIVITY_START_TIME }}]"
                   autocomplete="off"
                   value="{{ isset($article) ? $article->getMeta(\App\Models\Article::META_ACTIVITY_START_TIME) : '' }}" />
        </td>
    </tr>

    <tr>
        <th>活动结束</th>
        <td>
            <input type="text"
                   class="form-control meta-activity-end-at"
                   autocomplete="off"
                   name="meta[{{ \App\Models\Article::META_ACTIVITY_END_TIME }}]"
                   value="{{ isset($article) ? $article->getMeta(\App\Models\Article::META_ACTIVITY_END_TIME) : '' }}" />
        </td>
    </tr>

    <tr>
        <th>大学名称</th>
        <td>
            <input type="text"
                   class="form-control"
                   name="meta[{{ \App\Models\Article::META_UNIVERSITY }}]"
                   autocomplete="off"
                   value="{{ isset($article) ? $article->getMeta(\App\Models\Article::META_UNIVERSITY) : '' }}" />
        </td>
    </tr>
</table>

@push('after-scripts')
<script type="text/javascript" src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui/i18n/datepicker-zh-CN.js') }}"></script>
<script type="text/javascript">
$(function () {

    $('.meta-country-selector').chosen();
    $('.meta-country-selector').on('change', function () {
        var $options = $(this).find('option:selected');
        var selectedCountries = $(this).val();

        $('.meta-city-selector option').hide();
        $options.each(function () {
            $('.meta-city-selector option[data-root-id="' + $(this).data('id') + '"]').show();
        });

        var selectedCities = $('.meta-city-selector').val();
        $('.meta-city-selector option:selected').each(function () {
            var rootId = $(this).data('rootId');
            var country = $('.meta-country-selector option[data-id="' + rootId + '"]').val();
            var city = $(this).val();

            if ($.inArray(country, selectedCountries) == -1) {
                for (var sci in selectedCities) {
                    if (city == selectedCities[sci]) {
                        selectedCities.splice(sci, 1)
                    }
                }
            }
        });

        $('.meta-city-selector').val(selectedCities).trigger('chosen:updated');
    });

    $('.meta-city-selector').chosen();

    $('.meta-media-source-selector').chosen({
        allow_single_deselect: true
    });

    $( ".meta-activity-start-at" ).datepicker({
        dateFormat: 'yy-mm-dd',
        locale: 'zh-CN'
    });
    $( ".meta-activity-end-at" ).datepicker({
        dateFormat: 'yy-mm-dd',
        locale: 'zh-CN'
    });

});
</script>
@endpush