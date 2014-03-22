
function kickoff (url, what) {
  jQuery(document).ready(function ($) {
    window.setTimeout('loadTwitter("' + url + '","' + what + '")', 1000);
    window.setTimeout('loadFacebook("' + url + '","' + what + '")', 1000);
    //window.setTimeout('loadGoogle("' + url + '","' + what + '")', 1000);
  });
}

function abbreviateNumber(value) {
    var newValue = value;
    if (value >= 1000) {
        var suffixes = ["", "K", "M", "B", "T"];
        var suffixNum = Math.floor(("" + value).length / 3);
        var shortValue = '';
        for (var precision = 2; precision >= 1; precision--) {
            shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum)) : value).toPrecision(precision));
            var dotLessShortValue = (shortValue + '').replace(/[^a-zA-Z 0-9]+/g, '');
            if (dotLessShortValue.length <= 2) {
                break;
            }
        }
        if (shortValue % 1 != 0) shortNum = shortValue.toFixed(1);
        newValue = shortValue + suffixes[suffixNum];
    }
    return newValue;
}

function insertCount(where, what, count) {
    jQuery('.sb-' + where + '-' + what + '-count').text(abbreviateNumber(count));
}

function loadTwitter(url, what) {
    url = 'http://urls.api.twitter.com/1/urls/count.json?url=' + url + '&callback=?';

    jQuery.getJSON(url, function (data) {
        insertCount('twitter', what, data['count']);
    });
}

function loadFacebook(url, what) {
    url = 'https://api.facebook.com/method/fql.query?query=select total_count from link_stat where url="' + url + '"&format=json&callback=?';
    jQuery.getJSON(url, function (data) {
        insertCount('facebook', what, data[0]['total_count']);
    });
}

