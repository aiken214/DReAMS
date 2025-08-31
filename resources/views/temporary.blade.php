
@can('asset_item_edit')
                                ${(row.stocks.issued_quantity !== null || row.semi_expendables.issued_quantity !== null || row.properties.issued_quantity !== null) ? `
                                    <a class="btn btn-xs btn-info" href="{{ url('supply/asset_item') }}/${data}/edit">
                                        {{ trans('global.edit') }}
                                    </a>
                                ` : ''}
                            @endcan