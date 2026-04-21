$(function () {
    var updateCheck = function (e) {
        $(".required").prop('disabled', !$(e.currentTarget).prop('checked'));
    };
    var searchAddress = function (isSilent) {
        var postCode1 = $("#postcode1").val();
        var postCode2 = $("#postcode2").val();
        if (postCode1 === '' || postCode2 === '') {
            if (!isSilent) {
                alert("郵便番号を入力してください。");
            }
            return;
        }
        var url = "https://zipcloud.ibsnet.co.jp/api/search";
        $.ajax({
            type: "GET",
            cache: false,
            data: { zipcode: "" + postCode1 + postCode2 },
            url: url,
            async: true,
            dataType: "jsonp",
            headers: {
                "Content-Type": "application/json",
                "X-HTTP-Method-Override": "GET"
            }
        })
            .done(function (data) {
            var selectAddress = $("#select-address");
            selectAddress.children().remove();
            selectAddress.append($("<option>選択してください。</option>"));
            var _loop_1 = function (index) {
                var address = data['results'][index];
                var value = Object.keys(address).filter(function (key) { return key.includes("address"); }).sort().map(function (key) { return address[key]; }).join(' ');
                selectAddress.append($("<option>" + value + "</option>"));
            };
            for (var index in data['results']) {
                _loop_1(index);
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            if (!isSilent) {
                alert("住所が見つかりませんでした。");
            }
        });
    };
    var selectAddressChange = function (e) {
        var text = $(e.currentTarget).children(":selected").text();
        if (text === '' || text === '選択してください。') {
            return;
        }
        $("#address").val(text);
    };
    $("#agree").on('change', updateCheck);
    $("#agree").on('pageshow', updateCheck);
    $("#search").on('click', function (e) { searchAddress(false); });
    $("#agree").on('pageshow', function (e) { searchAddress(true); });
    $("#select-address").on('change', selectAddressChange);
    searchAddress(true);
});
