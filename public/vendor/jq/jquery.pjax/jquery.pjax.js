define(function (require) {
    return function (t) {
        (function (e) {
            function r(t, r, n) {
                var i = this;
                return this.on("click.pjax", t, function (t) {
                    var o = e.extend({}, j(r, n));
                    if (!o.container)o.container = e(this).attr("data-pjax") || i;
                    a(t, o)
                })
            }

            function a(t, r, a) {
                a = j(r, a);
                var n = t.currentTarget;
                if (n.tagName.toUpperCase() !== "A")throw"$.fn.pjax or $.pjax.click requires an anchor element";
                if (t.which > 1 || t.metaKey || t.ctrlKey || t.shiftKey || t.altKey)return;
                if (location.protocol !== n.protocol || location.hostname !== n.hostname)return;
                if (n.href.indexOf("#") > -1 && g(n) == g(location))return;
                if (t.isDefaultPrevented())return;
                var o = {url: n.href, container: e(n).attr("data-pjax"), target: n};
                var s = e.extend({}, o, a);
                var c = e.Event("pjax:click");
                e(n).trigger(c, [s]);
                if (!c.isDefaultPrevented()) {
                    i(s);
                    t.preventDefault();
                    e(n).trigger("pjax:clicked", [s])
                }
            }

            function n(t, r, a) {
                a = j(r, a);
                var n = t.currentTarget;
                var o = e(n);
                if (n.tagName.toUpperCase() !== "FORM")throw"$.pjax.submit requires a form element";
                var s = {
                    type: (o.attr("method") || "GET").toUpperCase(),
                    url: o.attr("action"),
                    container: o.attr("data-pjax"),
                    target: n
                };
                if (s.type !== "GET" && window.FormData !== undefined) {
                    s.data = new FormData(n);
                    s.processData = false;
                    s.contentType = false
                } else {
                    if (e(n).find(":file").length) {
                        return
                    }
                    s.data = e(n).serializeArray()
                }
                i(e.extend({}, s, a));
                t.preventDefault()
            }

            function i(t) {
                t = e.extend(true, {}, e.ajaxSettings, i.defaults, t);
                if (e.isFunction(t.url)) {
                    t.url = t.url()
                }
                var r = t.target;
                var a = x(t.url).hash;
                var n = t.context = y(t.container);
                if (!t.data)t.data = {};
                if (e.isArray(t.data)) {
                    t.data.push({name: "_pjax", value: n.selector})
                } else {
                    t.data._pjax = n.selector
                }
                function o(t, a, i) {
                    if (!i)i = {};
                    i.relatedTarget = r;
                    var o = e.Event(t, i);
                    n.trigger(o, a);
                    return !o.isDefaultPrevented()
                }

                var c;
                t.beforeSend = function (e, r) {
                    if (r.type !== "GET") {
                        r.timeout = 0
                    }
                    e.setRequestHeader("X-PJAX", "true");
                    e.setRequestHeader("X-PJAX-Container", n.selector);
                    if (!o("pjax:beforeSend", [e, r]))return false;
                    if (r.timeout > 0) {
                        c = setTimeout(function () {
                            if (o("pjax:timeout", [e, t]))e.abort("timeout")
                        }, r.timeout);
                        r.timeout = 0
                    }
                    var i = x(r.url);
                    if (a)i.hash = a;
                    t.requestUrl = m(i)
                };
                t.complete = function (e, r) {
                    if (c)clearTimeout(c);
                    o("pjax:complete", [e, r, t]);
                    o("pjax:end", [e, t])
                };
                t.error = function (e, r, a) {
                    var n = T("", e, t);
                    var i = o("pjax:error", [e, r, a, t]);
                    if (t.type == "GET" && r !== "abort" && i) {
                        s(n.url)
                    }
                };
                t.success = function (r, c, u) {
                    var l = i.state;
                    var f = typeof e.pjax.defaults.version === "function" ? e.pjax.defaults.version() : e.pjax.defaults.version;
                    var p = u.getResponseHeader("X-PJAX-Version");
                    var d = T(r, u, t);
                    var v = x(d.url);
                    if (a) {
                        v.hash = a;
                        d.url = v.href
                    }
                    if (f && p && f !== p) {
                        s(d.url);
                        return
                    }
                    if (!d.contents) {
                        s(d.url);
                        return
                    }
                    i.state = {
                        id: t.id || h(),
                        url: d.url,
                        title: d.title,
                        container: n.selector,
                        fragment: t.fragment,
                        timeout: t.timeout
                    };
                    if (t.push || t.replace) {
                        window.history.replaceState(i.state, d.title, d.url)
                    }
                    var m = e.contains(t.container, document.activeElement);
                    if (m) {
                        try {
                            document.activeElement.blur()
                        } catch (t) {
                        }
                    }
                    if (d.title)document.title = d.title;
                    o("pjax:beforeReplace", [d.contents, t], {state: i.state, previousState: l});
                    n.html(d.contents);
                    var g = n.find("input[autofocus], textarea[autofocus]").last()[0];
                    if (g && document.activeElement !== g) {
                        g.focus()
                    }
                    E(d.scripts);
                    var j = t.scrollTo;
                    if (a) {
                        var y = decodeURIComponent(a.slice(1));
                        var w = document.getElementById(y) || document.getElementsByName(y)[0];
                        if (w)j = e(w).offset().top
                    }
                    if (typeof j == "number")e(window).scrollTop(j);
                    o("pjax:success", [r, c, u, t])
                };
                if (!i.state) {
                    i.state = {
                        id: h(),
                        url: window.location.href,
                        title: document.title,
                        container: n.selector,
                        fragment: t.fragment,
                        timeout: t.timeout
                    };
                    window.history.replaceState(i.state, document.title)
                }
                d(i.xhr);
                i.options = t;
                var u = i.xhr = e.ajax(t);
                if (u.readyState > 0) {
                    if (t.push && !t.replace) {
                        A(i.state.id, v(n));
                        window.history.pushState(null, "", t.requestUrl)
                    }
                    o("pjax:start", [u, t]);
                    o("pjax:send", [u, t])
                }
                return i.xhr
            }

            function o(t, r) {
                var a = {url: window.location.href, push: false, replace: true, scrollTo: false};
                return i(e.extend(a, j(t, r)))
            }

            function s(t) {
                window.history.replaceState(null, "", i.state.url);
                window.location.replace(t)
            }

            var c = true;
            var u = window.location.href;
            var l = window.history.state;
            if (l && l.container) {
                i.state = l
            }
            if ("state" in window.history) {
                c = false
            }
            function f(t) {
                if (!c) {
                    d(i.xhr)
                }
                var r = i.state;
                var a = t.state;
                var n;
                if (a && a.container) {
                    if (c && u == a.url)return;
                    if (r) {
                        if (r.id === a.id)return;
                        n = r.id < a.id ? "forward" : "back"
                    }
                    var o = S[a.id] || [];
                    var l = e(o[0] || a.container), f = o[1];
                    if (l.length) {
                        if (r) {
                            D(n, r.id, v(l))
                        }
                        var p = e.Event("pjax:popstate", {state: a, direction: n});
                        l.trigger(p);
                        var h = {
                            id: a.id,
                            url: a.url,
                            container: l,
                            push: false,
                            fragment: a.fragment,
                            timeout: a.timeout,
                            scrollTo: false
                        };
                        if (f) {
                            l.trigger("pjax:start", [null, h]);
                            i.state = a;
                            if (a.title)document.title = a.title;
                            var m = e.Event("pjax:beforeReplace", {state: a, previousState: r});
                            l.trigger(m, [f, h]);
                            l.html(f);
                            l.trigger("pjax:end", [null, h])
                        } else {
                            i(h)
                        }
                        l[0].offsetHeight
                    } else {
                        s(location.href)
                    }
                }
                c = false
            }

            function p(t) {
                var r = e.isFunction(t.url) ? t.url() : t.url, a = t.type ? t.type.toUpperCase() : "GET";
                var n = e("<form>", {method: a === "GET" ? "GET" : "POST", action: r, style: "display:none"});
                if (a !== "GET" && a !== "POST") {
                    n.append(e("<input>", {type: "hidden", name: "_method", value: a.toLowerCase()}))
                }
                var i = t.data;
                if (typeof i === "string") {
                    e.each(i.split("&"), function (t, r) {
                        var a = r.split("=");
                        n.append(e("<input>", {type: "hidden", name: a[0], value: a[1]}))
                    })
                } else if (e.isArray(i)) {
                    e.each(i, function (t, r) {
                        n.append(e("<input>", {type: "hidden", name: r.name, value: r.value}))
                    })
                } else if (typeof i === "object") {
                    var o;
                    for (o in i)n.append(e("<input>", {type: "hidden", name: o, value: i[o]}))
                }
                e(document.body).append(n);
                n.submit()
            }

            function d(t) {
                if (t && t.readyState < 4) {
                    t.onreadystatechange = e.noop;
                    t.abort()
                }
            }

            function h() {
                return (new Date).getTime()
            }

            function v(e) {
                var r = e.clone();
                r.find("script").each(function () {
                    if (!this.src)t._data(this, "globalEval", false)
                });
                return [e.selector, r.contents()]
            }

            function m(t) {
                t.search = t.search.replace(/([?&])(_pjax|_)=[^&]*/g, "");
                return t.href.replace(/\?($|#)/, "$1")
            }

            function x(t) {
                var e = document.createElement("a");
                e.href = t;
                return e
            }

            function g(t) {
                return t.href.replace(/#.*/, "")
            }

            function j(t, r) {
                if (t && r)r.container = t; else if (e.isPlainObject(t))r = t; else r = {container: t};
                if (r.container)r.container = y(r.container);
                return r
            }

            function y(t) {
                t = e(t);
                if (!t.length) {
                    throw"no pjax container for " + t.selector
                } else if (t.selector !== "" && t.context === document) {
                    return t
                } else if (t.attr("id")) {
                    return e("#" + t.attr("id"))
                } else {
                    throw"cant get selector for pjax container!"
                }
            }

            function w(t, e) {
                return t.filter(e).add(t.find(e))
            }

            function b(t) {
                return e.parseHTML(t, document, true)
            }

            function T(t, r, a) {
                var n = {}, i = /<html/i.test(t);
                var o = r.getResponseHeader("X-PJAX-URL");
                n.url = o ? m(x(o)) : a.requestUrl;
                if (i) {
                    var s = e(b(t.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0]));
                    var c = e(b(t.match(/<body[^>]*>([\s\S.]*)<\/body>/i)[0]))
                } else {
                    var s = c = e(b(t))
                }
                if (c.length === 0)return n;
                n.title = w(s, "title").last().text();
                if (a.fragment) {
                    if (a.fragment === "body") {
                        var u = c
                    } else {
                        var u = w(c, a.fragment).first()
                    }
                    if (u.length) {
                        n.contents = a.fragment === "body" ? u : u.contents();
                        if (!n.title)n.title = u.attr("title") || u.data("title")
                    }
                } else if (!i) {
                    n.contents = c
                }
                if (n.contents) {
                    n.contents = n.contents.not(function () {
                        return e(this).is("title")
                    });
                    n.contents.find("title").remove();
                    n.scripts = w(n.contents, "script[src]").remove();
                    n.contents = n.contents.not(n.scripts)
                }
                if (n.title)n.title = e.trim(n.title);
                return n
            }

            function E(t) {
                if (!t)return;
                var r = e("script[src]");
                t.each(function () {
                    var t = this.src;
                    var a = r.filter(function () {
                        return this.src === t
                    });
                    if (a.length)return;
                    var n = document.createElement("script");
                    var i = e(this).attr("type");
                    if (i)n.type = i;
                    n.src = e(this).attr("src");
                    document.head.appendChild(n)
                })
            }

            var S = {};
            var P = [];
            var C = [];

            function A(t, e) {
                S[t] = e;
                C.push(t);
                R(P, 0);
                R(C, i.defaults.maxCacheLength)
            }

            function D(t, e, r) {
                var a, n;
                S[e] = r;
                if (t === "forward") {
                    a = C;
                    n = P
                } else {
                    a = P;
                    n = C
                }
                a.push(e);
                if (e = n.pop())delete S[e];
                R(a, i.defaults.maxCacheLength)
            }

            function R(t, e) {
                while (t.length > e)delete S[t.shift()]
            }

            function U() {
                return e("meta").filter(function () {
                    var t = e(this).attr("http-equiv");
                    return t && t.toUpperCase() === "X-PJAX-VERSION"
                }).attr("content")
            }

            function X() {
                e.fn.pjax = r;
                e.pjax = i;
                e.pjax.enable = e.noop;
                e.pjax.disable = G;
                e.pjax.click = a;
                e.pjax.submit = n;
                e.pjax.reload = o;
                e.pjax.defaults = {
                    timeout: 650,
                    push: true,
                    replace: false,
                    type: "GET",
                    dataType: "html",
                    scrollTo: 0,
                    maxCacheLength: 20,
                    version: U
                };
                e(window).on("popstate.pjax", f)
            }

            function G() {
                e.fn.pjax = function () {
                    return this
                };
                e.pjax = p;
                e.pjax.enable = X;
                e.pjax.disable = e.noop;
                e.pjax.click = e.noop;
                e.pjax.submit = e.noop;
                e.pjax.reload = function () {
                    window.location.reload()
                };
                e(window).off("popstate.pjax", f)
            }

            if (e.inArray("state", e.event.props) < 0)e.event.props.push("state");
            e.support.pjax = window.history && window.history.pushState && window.history.replaceState && !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/);
            e.support.pjax ? X() : G()
        })(t)
    }
});