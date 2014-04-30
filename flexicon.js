function getAllElementsWithAttribute(attribute)
{
    var matchingElements = [];
    var allElements = document.getElementsByTagName('link');
    for (var i = 0, n = allElements.length; i < n; i++)
    {
        if (allElements[i].getAttribute(attribute))
        {
            // Element exists with attribute. Add to array.
            matchingElements.push(allElements[i]);
        }
    }
    return matchingElements;
}

function SetFavicon() {
    var x =getAllElementsWithAttribute("data-flexicon");
    var path = x[0].getAttribute("data-flexicon");
    x[0].remove();
    var headNode = document.getElementsByTagName("head")[0];
    var icons = [
        {rel: "shortcut icon", size: null, href: "/ico"},
        {rel: "apple-touch-icon-precomposed", size: 152, href: "/png/152"},
        {rel: "apple-touch-icon-precomposed", size: 144, href: "/png/144"},
        {rel: "apple-touch-icon-precomposed", size: 120, href: "/png/120"},
        {rel: "apple-touch-icon-precomposed", size: 114, href: "/png/114"},
        {rel: "apple-touch-icon-precomposed", size: 76, href: "/png/76"},
        {rel: "apple-touch-icon-precomposed", size: 72, href: "/png/72"},
        {rel: "apple-touch-icon-precomposed", size: null, href: "/png/57"}
    ];
    var mscolor = "#FFFFFF";
    var msicons = [
        {name: "msapplication-TileImage", content: "/png/144"},
        {name: "msapplication-square70x70logo", content: "/png/128"},
        {name: "msapplication-square150x150logo", content: "/png/270"},
        {name: "msapplication-wide310x150logo", content: "/png/558"},
        {name: "msapplication-square310x310logo", content: "/png/558"}
    ];

    icons.forEach(function (element, index) {
        var favicon = document.createElement("link");
        favicon.setAttribute("rel", element.rel);
        favicon.setAttribute("href", path + element.href);
        if (element.size !== null) favicon.setAttribute("sizes", element.size + "x" + element.size);
        headNode.appendChild(favicon);
    });

    var msiconcolor = document.createElement("meta");
    msiconcolor.setAttribute("name", "msapplication-TileColor");
    msiconcolor.setAttribute("content", mscolor);
    headNode.appendChild(msiconcolor);

    msicons.forEach(function (element, index) {
        var favicon = document.createElement("meta");
        favicon.setAttribute("name", element.name);
        favicon.setAttribute("content", path + element.content);
        headNode.appendChild(favicon);
    });
}