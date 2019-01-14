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
                    .append(`<a href="${item.profile_url}" style="display:block">${item.firstname} ${item.lastname}</a>`)
                    .appendTo(ul);
            }
        };

        $('#q0').autocomplete(autoSearch.autocomplete);
        $('#q1').autocomplete(autoSearch.autocomplete);
        //$('#q2').autocomplete(autoSearch.autocomplete);

        $('#q0').autocomplete('instance')._renderItem = autoSearch._renderItem;
        $('#q1').autocomplete('instance')._renderItem = autoSearch._renderItem;
        //$('#q2').autocomplete('instance')._renderItem = autoSearch._renderItem;
    })
</script>