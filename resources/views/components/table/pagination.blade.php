<span class="sort-buttons">
    <button class="btn-sort btn-sort-up  @if($sort['field'] == $field && $sort['order'] == 'DESC') active @endif"
            type="button"
            data-sort-link="{{route($route,
array_merge([
    'sort_field' => $field,
    'sort_order' => 'DESC',
    'page' => $page
], $paramsRoute))}}"></button>
    <button class="btn-sort btn-sort-down @if($sort['field'] == $field && $sort['order'] == 'ASC') active @endif"

            data-sort-link="{{route($route,
array_merge([
    'sort_field' => $field,
    'sort_order' => 'ASC',
    'page' => $page
], $paramsRoute))}}"
                type=" button"
    ></button>
</span>
