<script>
    $(function () {
        var autoSearch = {
            autocomplete: {
                source: function (request, response) {
                    $.get({
                        url: '{{ route('api.search.people') }}',
                        data: { q: request.term }
                    }).done(function (data) {
                        //console.log(data);
                        response(data)
                    }).fail(function () {
                        response([])
                    })
                },
                select: function (event, ui) {
                    $(this).val(`${ui.item.firstname} ${ui.item.lastname}`);
                    return false;
                }
            },
            _renderItem: function (ul, item) {
                return $('<li>')
                    .append(`
                        <a href="${item.profile_url}" style="display:block;text-decoration:none">
                            ${item.firstname} ${item.lastname}
                        </a>
                    `)
                    .appendTo(ul);
            }
        };

        var as0 = $('#q0').autocomplete(autoSearch.autocomplete);
        var as1 = $('#q1').autocomplete(autoSearch.autocomplete);

        if ((asi = as0.autocomplete('instance'))) {
            asi._renderItem = autoSearch._renderItem;
        }

        if ((asi = as1.autocomplete('instance'))) {
            asi._renderItem = autoSearch._renderItem;
        }

    })
</script>