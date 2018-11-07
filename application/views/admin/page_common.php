<script id="paginateTemplate" type="x-tmpl-mustache">
<div class="dataTables_paginate paging_simple_numbers pull-right" id="dynamic-table_paginate">
                  {{from}}-{{to}}/{{total}}
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm page-action" data-target="{{beforePageNo}}" data-url="{{beforeUrl}}" {{^beforeUrl}}disabled{{/beforeUrl}}><i class="fa fa-chevron-left"></i></button>
            <button type="button" class="btn btn-default btn-sm page-action" data-target="{{nextPageNo}}" data-url="{{nextUrl}}" {{^nextUrl}}disabled{{/nextUrl}}><i class="fa fa-chevron-right"></i></button>
            <input type="hidden" class="pageNo" value="{{pageNo}}" />
        </div>
    </div>
</script>

<script type="text/javascript">
    var paginateTemplate = $("#paginateTemplate").html();
    Mustache.parse(paginateTemplate);

    function renderPage(url, total, pageNo, pageSize, currentSize, idElement, callback) {
        var maxPageNo = Math.ceil(total / pageSize);
        var paramStartChar = url.indexOf("?") > 0 ? "&" : "?";
        var from = (pageNo - 1) * pageSize + 1;
        var view = {
            from: from > total ? total : from,
            to: (from + currentSize - 1) > total ? total : (from + currentSize - 1),
            total : total,
            pageNo : pageNo,
            maxPageNo : maxPageNo,
            nextPageNo: pageNo >= maxPageNo ? maxPageNo : (pageNo + 1),
            beforePageNo : pageNo == 1 ? 1 : (pageNo - 1),
            beforeUrl: (pageNo == 1) ? '' : (url + paramStartChar + "pageNo=" + (pageNo - 1) + "&pageSize=" + pageSize),
            nextUrl : (pageNo >= maxPageNo) ? '' : (url + paramStartChar + "pageNo=" + (pageNo + 1) + "&pageSize=" + pageSize)
        };
        $("#" + idElement).html(Mustache.render(paginateTemplate, view));

        $(".page-action").click(function(e) {
            e.preventDefault();
            $("#" + idElement + " .pageNo").val($(this).attr("data-target"));
            var targetUrl  = $(this).attr("data-url");
            if(targetUrl != '') {
                $.ajax({
                    type:'get',
                    dataType:'json',
                    url : targetUrl,
                    success: function (result) {
                        if (callback) {
                            callback(result, url);
                        }
                    }
                })
            }
        })
    }
</script>