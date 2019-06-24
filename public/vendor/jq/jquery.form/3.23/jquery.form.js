define(function (require) {
    return function (e) {
        (function (t) {
            "use strict";
            var r = {};
            r.fileapi = t("<input type='file'/>").get(0).files !== undefined;
            r.formdata = window.FormData !== undefined;
            t.fn.ajaxSubmit = function (a) {
                if (!this.length) {
                    n("ajaxSubmit: skipping submit process - no element selected");
                    return this
                }
                var i, o, s, f = this;
                if (typeof a == "function") {
                    a = {success: a}
                }
                i = this.attr("method");
                o = this.attr("action");
                s = typeof o === "string" ? t.trim(o) : "";
                s = s || window.location.href || "";
                if (s) {
                    s = (s.match(/^([^#]+)/) || [])[1]
                }
                a = t.extend(true, {
                    url: s,
                    success: t.ajaxSettings.success,
                    type: i || "GET",
                    iframeSrc: /^https/i.test(window.location.href || "") ? "javascript:false" : "about:blank"
                }, a);
                var l = {};
                this.trigger("form-pre-serialize", [this, a, l]);
                if (l.veto) {
                    n("ajaxSubmit: submit vetoed via form-pre-serialize trigger");
                    return this
                }
                if (a.beforeSerialize && a.beforeSerialize(this, a) === false) {
                    n("ajaxSubmit: submit aborted via beforeSerialize callback");
                    return this
                }
                var u = a.traditional;
                if (u === undefined) {
                    u = t.ajaxSettings.traditional
                }
                var c = [];
                var d, m = this.formToArray(a.semantic, c);
                if (a.data) {
                    a.extraData = a.data;
                    d = t.param(a.data, u)
                }
                if (a.beforeSubmit && a.beforeSubmit(m, this, a) === false) {
                    n("ajaxSubmit: submit aborted via beforeSubmit callback");
                    return this
                }
                this.trigger("form-submit-validate", [m, this, a, l]);
                if (l.veto) {
                    n("ajaxSubmit: submit vetoed via form-submit-validate trigger");
                    return this
                }
                var p = t.param(m, u);
                if (d) {
                    p = p ? p + "&" + d : d
                }
                if (a.type.toUpperCase() == "GET") {
                    a.url += (a.url.indexOf("?") >= 0 ? "&" : "?") + p;
                    a.data = null
                } else {
                    a.data = p
                }
                var v = [];
                if (a.resetForm) {
                    v.push(function () {
                        f.resetForm()
                    })
                }
                if (a.clearForm) {
                    v.push(function () {
                        f.clearForm(a.includeHidden)
                    })
                }
                if (!a.dataType && a.target) {
                    var h = a.success || function () {
                        };
                    v.push(function (e) {
                        var r = a.replaceTarget ? "replaceWith" : "html";
                        t(a.target)[r](e).each(h, arguments)
                    })
                } else if (a.success) {
                    v.push(a.success)
                }
                a.success = function (e, t, r) {
                    var i = a.context || this;
                    for (var n = 0, o = v.length; n < o; n++) {
                        v[n].apply(i, [e, t, r || f, f])
                    }
                };
                var g = t('input[type=file]:enabled[value!=""]', this);
                var x = g.length > 0;
                var b = "multipart/form-data";
                var y = f.attr("enctype") == b || f.attr("encoding") == b;
                var T = r.fileapi && r.formdata;
                n("fileAPI :" + T);
                var j = (x || y) && !T;
                var w;
                if (a.iframe !== false && (a.iframe || j)) {
                    if (a.closeKeepAlive) {
                        t.get(a.closeKeepAlive, function () {
                            w = A(m)
                        })
                    } else {
                        w = A(m)
                    }
                } else if ((x || y) && T) {
                    w = D(m)
                } else {
                    w = t.ajax(a)
                }
                f.removeData("jqxhr").data("jqxhr", w);
                for (var S = 0; S < c.length; S++)c[S] = null;
                this.trigger("form-submit-notify", [this, a]);
                return this;
                function k(e) {
                    var r = t.param(e).split("&");
                    var a = r.length;
                    var i = {};
                    var n, o;
                    for (n = 0; n < a; n++) {
                        r[n] = r[n].replace(/\+/g, " ");
                        o = r[n].split("=");
                        i[decodeURIComponent(o[0])] = decodeURIComponent(o[1])
                    }
                    return i
                }

                function D(r) {
                    var n = new FormData;
                    for (var o = 0; o < r.length; o++) {
                        n.append(r[o].name, r[o].value)
                    }
                    if (a.extraData) {
                        var s = k(a.extraData);
                        for (var f in s)if (s.hasOwnProperty(f))n.append(f, s[f])
                    }
                    a.data = null;
                    var l = t.extend(true, {}, t.ajaxSettings, a, {
                        contentType: false,
                        processData: false,
                        cache: false,
                        type: i || "POST"
                    });
                    if (a.uploadProgress) {
                        l.xhr = function () {
                            var t = e.ajaxSettings.xhr();
                            if (t.upload) {
                                t.upload.onprogress = function (e) {
                                    var t = 0;
                                    var r = e.loaded || e.position;
                                    var i = e.total;
                                    if (e.lengthComputable) {
                                        t = Math.ceil(r / i * 100)
                                    }
                                    a.uploadProgress(e, r, i, t)
                                }
                            }
                            return t
                        }
                    }
                    l.data = null;
                    var u = l.beforeSend;
                    l.beforeSend = function (e, t) {
                        t.data = n;
                        if (u)u.call(this, e, t)
                    };
                    return t.ajax(l)
                }

                function A(e) {
                    var r = f[0], o, s, l, u, d, m, p, v, h, g, x, b;
                    var y = !!t.fn.prop;
                    var T = t.Deferred();
                    if (t("[name=submit],[id=submit]", r).length) {
                        alert('Error: Form elements must not have name or id of "submit".');
                        T.reject();
                        return T
                    }
                    if (e) {
                        for (s = 0; s < c.length; s++) {
                            o = t(c[s]);
                            if (y)o.prop("disabled", false); else o.removeAttr("disabled")
                        }
                    }
                    l = t.extend(true, {}, t.ajaxSettings, a);
                    l.context = l.context || l;
                    d = "jqFormIO" + (new Date).getTime();
                    if (l.iframeTarget) {
                        m = t(l.iframeTarget);
                        g = m.attr("name");
                        if (!g)m.attr("name", d); else d = g
                    } else {
                        m = t('<iframe name="' + d + '" src="' + l.iframeSrc + '" />');
                        m.css({position: "absolute", top: "-1000px", left: "-1000px"})
                    }
                    p = m[0];
                    v = {
                        aborted: 0,
                        responseText: null,
                        responseXML: null,
                        status: 0,
                        statusText: "n/a",
                        getAllResponseHeaders: function () {
                        },
                        getResponseHeader: function () {
                        },
                        setRequestHeader: function () {
                        },
                        abort: function (e) {
                            var r = e === "timeout" ? "timeout" : "aborted";
                            n("aborting upload... " + r);
                            this.aborted = 1;
                            try {
                                if (p.contentWindow.document.execCommand) {
                                    p.contentWindow.document.execCommand("Stop")
                                }
                            } catch (e) {
                            }
                            m.attr("src", l.iframeSrc);
                            v.error = r;
                            if (l.error)l.error.call(l.context, v, r, e);
                            if (u)t.event.trigger("ajaxError", [v, l, r]);
                            if (l.complete)l.complete.call(l.context, v, r)
                        }
                    };
                    u = l.global;
                    if (u && 0 === t.active++) {
                        t.event.trigger("ajaxStart")
                    }
                    if (u) {
                        t.event.trigger("ajaxSend", [v, l])
                    }
                    if (l.beforeSend && l.beforeSend.call(l.context, v, l) === false) {
                        if (l.global) {
                            t.active--
                        }
                        T.reject();
                        return T
                    }
                    if (v.aborted) {
                        T.reject();
                        return T
                    }
                    h = r.clk;
                    if (h) {
                        g = h.name;
                        if (g && !h.disabled) {
                            l.extraData = l.extraData || {};
                            l.extraData[g] = h.value;
                            if (h.type == "image") {
                                l.extraData[g + ".x"] = r.clk_x;
                                l.extraData[g + ".y"] = r.clk_y
                            }
                        }
                    }
                    var j = 1;
                    var w = 2;

                    function S(e) {
                        var t = e.contentWindow ? e.contentWindow.document : e.contentDocument ? e.contentDocument : e.document;
                        return t
                    }

                    var k = t("meta[name=csrf-token]").attr("content");
                    var D = t("meta[name=csrf-param]").attr("content");
                    if (D && k) {
                        l.extraData = l.extraData || {};
                        l.extraData[D] = k
                    }
                    function A() {
                        var e = f.attr("target"), a = f.attr("action");
                        r.setAttribute("target", d);
                        if (!i) {
                            r.setAttribute("method", "POST")
                        }
                        if (a != l.url) {
                            r.setAttribute("action", l.url)
                        }
                        if (!l.skipEncodingOverride && (!i || /post/i.test(i))) {
                            f.attr({encoding: "multipart/form-data", enctype: "multipart/form-data"})
                        }
                        if (l.timeout) {
                            b = setTimeout(function () {
                                x = true;
                                O(j)
                            }, l.timeout)
                        }
                        function o() {
                            try {
                                var e = S(p).readyState;
                                n("state = " + e);
                                if (e && e.toLowerCase() == "uninitialized")setTimeout(o, 50)
                            } catch (e) {
                                n("Server abort: ", e, " (", e.name, ")");
                                O(w);
                                if (b)clearTimeout(b);
                                b = undefined
                            }
                        }

                        var s = [];
                        try {
                            if (l.extraData) {
                                for (var u in l.extraData) {
                                    if (l.extraData.hasOwnProperty(u)) {
                                        if (t.isPlainObject(l.extraData[u]) && l.extraData[u].hasOwnProperty("name") && l.extraData[u].hasOwnProperty("value")) {
                                            s.push(t('<input type="hidden" name="' + l.extraData[u].name + '">').attr("value", l.extraData[u].value).appendTo(r)[0])
                                        } else {
                                            s.push(t('<input type="hidden" name="' + u + '">').attr("value", l.extraData[u]).appendTo(r)[0])
                                        }
                                    }
                                }
                            }
                            if (!l.iframeTarget) {
                                m.appendTo("body");
                                if (p.attachEvent)p.attachEvent("onload", O); else p.addEventListener("load", O, false)
                            }
                            setTimeout(o, 15);
                            r.submit()
                        } finally {
                            r.setAttribute("action", a);
                            if (e) {
                                r.setAttribute("target", e)
                            } else {
                                f.removeAttr("target")
                            }
                            t(s).remove()
                        }
                    }

                    if (l.forceSync) {
                        A()
                    } else {
                        setTimeout(A, 10)
                    }
                    var L, E, M = 50, F;

                    function O(e) {
                        if (v.aborted || F) {
                            return
                        }
                        try {
                            E = S(p)
                        } catch (t) {
                            n("cannot access response document: ", t);
                            e = w
                        }
                        if (e === j && v) {
                            v.abort("timeout");
                            T.reject(v, "timeout");
                            return
                        } else if (e == w && v) {
                            v.abort("server abort");
                            T.reject(v, "error", "server abort");
                            return
                        }
                        if (!E || E.location.href == l.iframeSrc) {
                            if (!x)return
                        }
                        if (p.detachEvent)p.detachEvent("onload", O); else p.removeEventListener("load", O, false);
                        var r = "success", a;
                        try {
                            if (x) {
                                throw"timeout"
                            }
                            var i = l.dataType == "xml" || E.XMLDocument || t.isXMLDoc(E);
                            n("isXml=" + i);
                            if (!i && window.opera && (E.body === null || !E.body.innerHTML)) {
                                if (--M) {
                                    n("requeing onLoad callback, DOM not available");
                                    setTimeout(O, 250);
                                    return
                                }
                            }
                            var o = E.body ? E.body : E.documentElement;
                            v.responseText = o ? o.innerHTML : null;
                            v.responseXML = E.XMLDocument ? E.XMLDocument : E;
                            if (i)l.dataType = "xml";
                            v.getResponseHeader = function (e) {
                                var t = {"content-type": l.dataType};
                                return t[e]
                            };
                            if (o) {
                                v.status = Number(o.getAttribute("status")) || v.status;
                                v.statusText = o.getAttribute("statusText") || v.statusText
                            }
                            var s = (l.dataType || "").toLowerCase();
                            var f = /(json|script|text)/.test(s);
                            if (f || l.textarea) {
                                var c = E.getElementsByTagName("textarea")[0];
                                if (c) {
                                    v.responseText = c.value;
                                    v.status = Number(c.getAttribute("status")) || v.status;
                                    v.statusText = c.getAttribute("statusText") || v.statusText
                                } else if (f) {
                                    var d = E.getElementsByTagName("pre")[0];
                                    var h = E.getElementsByTagName("body")[0];
                                    if (d) {
                                        v.responseText = d.textContent ? d.textContent : d.innerText
                                    } else if (h) {
                                        v.responseText = h.textContent ? h.textContent : h.innerText
                                    }
                                }
                            } else if (s == "xml" && !v.responseXML && v.responseText) {
                                v.responseXML = X(v.responseText)
                            }
                            try {
                                L = _(v, s, l)
                            } catch (e) {
                                r = "parsererror";
                                v.error = a = e || r
                            }
                        } catch (e) {
                            n("error caught: ", e);
                            r = "error";
                            v.error = a = e || r
                        }
                        if (v.aborted) {
                            n("upload aborted");
                            r = null
                        }
                        if (v.status) {
                            r = v.status >= 200 && v.status < 300 || v.status === 304 ? "success" : "error"
                        }
                        if (r === "success") {
                            if (l.success)l.success.call(l.context, L, "success", v);
                            T.resolve(v.responseText, "success", v);
                            if (u)t.event.trigger("ajaxSuccess", [v, l])
                        } else if (r) {
                            if (a === undefined)a = v.statusText;
                            if (l.error)l.error.call(l.context, v, r, a);
                            T.reject(v, "error", a);
                            if (u)t.event.trigger("ajaxError", [v, l, a])
                        }
                        if (u)t.event.trigger("ajaxComplete", [v, l]);
                        if (u && !--t.active) {
                            t.event.trigger("ajaxStop")
                        }
                        if (l.complete)l.complete.call(l.context, v, r);
                        F = true;
                        if (l.timeout)clearTimeout(b);
                        setTimeout(function () {
                            if (!l.iframeTarget)m.remove();
                            v.responseXML = null
                        }, 100)
                    }

                    var X = t.parseXML || function (e, t) {
                            if (window.ActiveXObject) {
                                t = new ActiveXObject("Microsoft.XMLDOM");
                                t.async = "false";
                                t.loadXML(e)
                            } else {
                                t = (new DOMParser).parseFromString(e, "text/xml")
                            }
                            return t && t.documentElement && t.documentElement.nodeName != "parsererror" ? t : null
                        };
                    var C = t.parseJSON || function (e) {
                            return window["eval"]("(" + e + ")")
                        };
                    var _ = function (e, r, a) {
                        var i = e.getResponseHeader("content-type") || "", n = r === "xml" || !r && i.indexOf("xml") >= 0, o = n ? e.responseXML : e.responseText;
                        if (n && o.documentElement.nodeName === "parsererror") {
                            if (t.error)t.error("parsererror")
                        }
                        if (a && a.dataFilter) {
                            o = a.dataFilter(o, r)
                        }
                        if (typeof o === "string") {
                            if (r === "json" || !r && i.indexOf("json") >= 0) {
                                o = C(o)
                            } else if (r === "script" || !r && i.indexOf("javascript") >= 0) {
                                t.globalEval(o)
                            }
                        }
                        return o
                    };
                    return T
                }
            };
            t.fn.ajaxForm = function (e) {
                e = e || {};
                e.delegation = e.delegation && t.isFunction(t.fn.on);
                if (!e.delegation && this.length === 0) {
                    var r = {s: this.selector, c: this.context};
                    if (!t.isReady && r.s) {
                        n("DOM not ready, queuing ajaxForm");
                        t(function () {
                            t(r.s, r.c).ajaxForm(e)
                        });
                        return this
                    }
                    n("terminating; zero elements found by selector" + (t.isReady ? "" : " (DOM not ready)"));
                    return this
                }
                if (e.delegation) {
                    t(document).off("submit.form-plugin", this.selector, a).off("click.form-plugin", this.selector, i).on("submit.form-plugin", this.selector, e, a).on("click.form-plugin", this.selector, e, i);
                    return this
                }
                return this.ajaxFormUnbind().bind("submit.form-plugin", e, a).bind("click.form-plugin", e, i)
            };
            function a(e) {
                var r = e.data;
                if (!e.isDefaultPrevented()) {
                    e.preventDefault();
                    t(this).ajaxSubmit(r)
                }
            }

            function i(e) {
                var r = e.target;
                var a = t(r);
                if (!a.is("[type=submit],[type=image]")) {
                    var i = a.closest("[type=submit]");
                    if (i.length === 0) {
                        return
                    }
                    r = i[0]
                }
                var n = this;
                n.clk = r;
                if (r.type == "image") {
                    if (e.offsetX !== undefined) {
                        n.clk_x = e.offsetX;
                        n.clk_y = e.offsetY
                    } else if (typeof t.fn.offset == "function") {
                        var o = a.offset();
                        n.clk_x = e.pageX - o.left;
                        n.clk_y = e.pageY - o.top
                    } else {
                        n.clk_x = e.pageX - r.offsetLeft;
                        n.clk_y = e.pageY - r.offsetTop
                    }
                }
                setTimeout(function () {
                    n.clk = n.clk_x = n.clk_y = null
                }, 100)
            }

            t.fn.ajaxFormUnbind = function () {
                return this.unbind("submit.form-plugin click.form-plugin")
            };
            t.fn.formToArray = function (e, a) {
                var i = [];
                if (this.length === 0) {
                    return i
                }
                var n = this[0];
                var o = e ? n.getElementsByTagName("*") : n.elements;
                if (!o) {
                    return i
                }
                var s, f, l, u, c, d, m;
                for (s = 0, d = o.length; s < d; s++) {
                    c = o[s];
                    l = c.name;
                    if (!l) {
                        continue
                    }
                    if (e && n.clk && c.type == "image") {
                        if (!c.disabled && n.clk == c) {
                            i.push({name: l, value: t(c).val(), type: c.type});
                            i.push({name: l + ".x", value: n.clk_x}, {name: l + ".y", value: n.clk_y})
                        }
                        continue
                    }
                    u = t.fieldValue(c, true);
                    if (u && u.constructor == Array) {
                        if (a)a.push(c);
                        for (f = 0, m = u.length; f < m; f++) {
                            i.push({name: l, value: u[f]})
                        }
                    } else if (r.fileapi && c.type == "file" && !c.disabled) {
                        if (a)a.push(c);
                        var p = c.files;
                        if (p.length) {
                            for (f = 0; f < p.length; f++) {
                                i.push({name: l, value: p[f], type: c.type})
                            }
                        } else {
                            i.push({name: l, value: "", type: c.type})
                        }
                    } else if (u !== null && typeof u != "undefined") {
                        if (a)a.push(c);
                        i.push({name: l, value: u, type: c.type, required: c.required})
                    }
                }
                if (!e && n.clk) {
                    var v = t(n.clk), h = v[0];
                    l = h.name;
                    if (l && !h.disabled && h.type == "image") {
                        i.push({name: l, value: v.val()});
                        i.push({name: l + ".x", value: n.clk_x}, {name: l + ".y", value: n.clk_y})
                    }
                }
                return i
            };
            t.fn.formSerialize = function (e) {
                return t.param(this.formToArray(e))
            };
            t.fn.fieldSerialize = function (e) {
                var r = [];
                this.each(function () {
                    var a = this.name;
                    if (!a) {
                        return
                    }
                    var i = t.fieldValue(this, e);
                    if (i && i.constructor == Array) {
                        for (var n = 0, o = i.length; n < o; n++) {
                            r.push({name: a, value: i[n]})
                        }
                    } else if (i !== null && typeof i != "undefined") {
                        r.push({name: this.name, value: i})
                    }
                });
                return t.param(r)
            };
            t.fn.fieldValue = function (e) {
                for (var r = [], a = 0, i = this.length; a < i; a++) {
                    var n = this[a];
                    var o = t.fieldValue(n, e);
                    if (o === null || typeof o == "undefined" || o.constructor == Array && !o.length) {
                        continue
                    }
                    if (o.constructor == Array)t.merge(r, o); else r.push(o)
                }
                return r
            };
            t.fieldValue = function (e, r) {
                var a = e.name, i = e.type, n = e.tagName.toLowerCase();
                if (r === undefined) {
                    r = true
                }
                if (r && (!a || e.disabled || i == "reset" || i == "button" || (i == "checkbox" || i == "radio") && !e.checked || (i == "submit" || i == "image") && e.form && e.form.clk != e || n == "select" && e.selectedIndex == -1)) {
                    return null
                }
                if (n == "select") {
                    var o = e.selectedIndex;
                    if (o < 0) {
                        return null
                    }
                    var s = [], f = e.options;
                    var l = i == "select-one";
                    var u = l ? o + 1 : f.length;
                    for (var c = l ? o : 0; c < u; c++) {
                        var d = f[c];
                        if (d.selected) {
                            var m = d.value;
                            if (!m) {
                                m = d.attributes && d.attributes["value"] && !d.attributes["value"].specified ? d.text : d.value
                            }
                            if (l) {
                                return m
                            }
                            s.push(m)
                        }
                    }
                    return s
                }
                return t(e).val()
            };
            t.fn.clearForm = function (e) {
                return this.each(function () {
                    t("input,select,textarea", this).clearFields(e)
                })
            };
            t.fn.clearFields = t.fn.clearInputs = function (e) {
                var r = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
                return this.each(function () {
                    var a = this.type, i = this.tagName.toLowerCase();
                    if (r.test(a) || i == "textarea") {
                        this.value = ""
                    } else if (a == "checkbox" || a == "radio") {
                        this.checked = false
                    } else if (i == "select") {
                        this.selectedIndex = -1
                    } else if (a == "file") {
                        if (t.browser.msie) {
                            t(this).replaceWith(t(this).clone())
                        } else {
                            t(this).val("")
                        }
                    } else if (e) {
                        if (e === true && /hidden/.test(a) || typeof e == "string" && t(this).is(e))this.value = ""
                    }
                })
            };
            t.fn.resetForm = function () {
                return this.each(function () {
                    if (typeof this.reset == "function" || typeof this.reset == "object" && !this.reset.nodeType) {
                        this.reset()
                    }
                })
            };
            t.fn.enable = function (e) {
                if (e === undefined) {
                    e = true
                }
                return this.each(function () {
                    this.disabled = !e
                })
            };
            t.fn.selected = function (e) {
                if (e === undefined) {
                    e = true
                }
                return this.each(function () {
                    var r = this.type;
                    if (r == "checkbox" || r == "radio") {
                        this.checked = e
                    } else if (this.tagName.toLowerCase() == "option") {
                        var a = t(this).parent("select");
                        if (e && a[0] && a[0].type == "select-one") {
                            a.find("option").selected(false)
                        }
                        this.selected = e
                    }
                })
            };
            t.fn.ajaxSubmit.debug = false;
            function n() {
                if (!t.fn.ajaxSubmit.debug)return;
                var e = "[jquery.form] " + Array.prototype.join.call(arguments, "");
                if (window.console && window.console.log) {
                    window.console.log(e)
                } else if (window.opera && window.opera.postError) {
                    window.opera.postError(e)
                }
            }
        })(e)
    }
});