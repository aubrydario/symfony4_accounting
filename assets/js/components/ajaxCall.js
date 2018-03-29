export default function ajax(type, url, {data = null, dataType = 'json', async = true, contentType = 'application/json; charset=utf-8', complete = null} = {}) {
    return $.ajax({
        type: type,
        dataType: dataType,
        url: url,
        data: data,
        async: async,
        contentType: contentType,
        complete: complete
    });
}