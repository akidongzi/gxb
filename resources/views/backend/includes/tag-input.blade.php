<select class="tag-input form-control" multiple name="labels[]" data-placeholder="请输入/选择标签">
    <option value=""></option>
    @if(! empty($selectedLabels))
        @foreach($selectedLabels as $label)
            <option class="tag-input-item" value="{{ $label->id }}" selected>{{ $label->name }}</option>
        @endforeach
    @endif
</select>

<div class="clearfix">&nbsp;</div>
<p>
    <a data-toggle-text="隐藏标签列表&lt;&lt;" data-status="off" class="tag-input__tag-list-toggle" href="javascript:;">显示标签列表&gt;&gt;</a>
</p>

<div class="form-group row tag-switch" style="display:none;">
    @foreach($labels as $k => $label)
        <div class="checkbox col-md-2">
            <label class="switch switch-sm switch-3d switch-primary"
                   for="permission-{{$k}}"><input
                        class="switch-input" type="checkbox" @if(! empty($selectedLabels) && in_array($label->id, $selectedLabels->pluck('id')->toArray())) checked @endif
                id="permission-{{$k}}" value="{{$label->id}}"><span
                        class="switch-label"></span><span
                        class="switch-handle"></span></label>
            <label class="tag-switch__tag-name" data-id="{{ $label->id }}" for="permission-{{ $k }}">{{$label->name}}</label>
        </div>
    @endforeach
</div>

@push('after-scripts')
<script type="text/javascript">
$(function () {
    $('.tag-input').chosen();

    var stmo;
    function abortPreviousSearch()
    {
        clearTimeout(stmo);
    }
    function update_tag_input(data)
    {
        var html = '';
        for (var i in data) {
            var $tagItem = $('.tag-input option[value="' + data[i].id + '"]');
            if ($tagItem.length == 0) {
                html += '<option class="tag-input-item" value="' + data[i].id + '">' + data[i].name + '</option>';
            }
        }

        $('.tag-input').append(html);
    }
    $($('.tag-input')[0].nextSibling).find('.chosen-search-input').on('keyup', function (){
        var kw = $(this).val();
        if (! kw) {
            return;
        }

        abortPreviousSearch();
        stmo = setTimeout(function () {
            $('.tag-input').find('.tag-input-item:not(:selected)').remove();

            if (! kw) {
                return;
            }

            var tags = [];
            $('.tag-switch__tag-name:contains("' + kw + '")').each(function () {
                tags.push({
                    id: $(this).data('id'),
                    name: $(this).html()
                });
            });

            update_tag_input(tags);
            $('.tag-input').trigger('chosen:updated');

        }, 200);
    });

    $('.tag-input').on('change', function () {
        var tags = $(this).val();
        $('.tag-switch .switch-input').prop('checked', false);
        for (var i in tags) {
            $('.tag-switch .switch-input[value="' + tags[i] + '"]').prop('checked', true);
        }
    });

    $('.tag-switch .switch-input').on('change', function () {
        if ($(this).prop('checked')) {
            var $tagItem = $('.tag-input option[value="' + $(this).val() + '"]');
            if ($tagItem.length > 0) {
                $tagItem.prop('selected', true);
            } else {
                var optionHtml = '<option class="tag-input-item" value="' + $(this).val() + '" selected>' + $('label[data-id="' + $(this).val() + '"]').html() + '</option>';
                $('.tag-input').append(optionHtml);
            }

        } else {
            $('.tag-input option[value="' + $(this).val() + '"]').prop('selected', false);
        }

        $('.tag-input').trigger('chosen:updated');
    });

    $('.tag-input__tag-list-toggle').on('click', function () {
        var text = $(this).html();
        if ($(this).data('status') == 'off') {
            $('.tag-switch').show();
            $(this).data('status', 'on');
        } else {
            $('.tag-switch').hide();
            $(this).data('status', 'off');
        }

        $(this).html($(this).data('toggle-text'));
        $(this).data('toggle-text', text);
    });
});
</script>
@endpush