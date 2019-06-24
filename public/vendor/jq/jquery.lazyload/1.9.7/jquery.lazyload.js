define(function (require) {
    return function (e) {
        (function (e, t, i, n) {
            var o = e(t);
            e.fn.lazyload = function (r) {
                var f = this;
                var l;
                var a = {
                    threshold: 200,
                    failure_limit: 0,
                    event: "scroll",
                    effect: "fadeIn",
                    container: t,
                    data_attribute: "original",
                    skip_invisible: false,
                    appear: null,
                    load: null,
                    placeholder: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                };

                function h() {
                    var t = 0;
                    f.each(function () {
                        var i = e(this);
                        if (a.skip_invisible && !i.is(":visible")) {
                            return
                        }
                        if (e.abovethetop(this, a) || e.leftofbegin(this, a)) {
                        } else if (!e.belowthefold(this, a) && !e.rightoffold(this, a)) {
                            i.trigger("appear");
                            t = 0
                        } else {
                            if (++t > a.failure_limit) {
                                return false
                            }
                        }
                    })
                }

                if (r) {
                    if (n !== r.failurelimit) {
                        r.failure_limit = r.failurelimit;
                        delete r.failurelimit
                    }
                    if (n !== r.effectspeed) {
                        r.effect_speed = r.effectspeed;
                        delete r.effectspeed
                    }
                    e.extend(a, r)
                }
                l = a.container === n || a.container === t ? o : e(a.container);
                if (0 === a.event.indexOf("scroll")) {
                    l.on(a.event, function () {
                        return h()
                    })
                }
                this.each(function () {
                    var t = this;
                    var i = e(t);
                    t.loaded = false;
                    if (i.attr("src") === n || i.attr("src") === false) {
                        if (i.is("img")) {
                            i.attr("src", a.placeholder)
                        }
                    }
                    i.one("appear", function () {
                        if (!this.loaded) {
                            if (a.appear) {
                                var n = f.length;
                                a.appear.call(t, n, a)
                            }
                            e("<img />").one("load", function () {
                                var n = i.attr("data-" + a.data_attribute);
                                i.hide();
                                if (i.is("img")) {
                                    i.attr("src", n)
                                } else {
                                    i.css("background-image", "url('" + n + "')")
                                }
                                i[a.effect](a.effect_speed);
                                t.loaded = true;
                                var o = e.grep(f, function (e) {
                                    return !e.loaded
                                });
                                f = e(o);
                                if (a.load) {
                                    var r = f.length;
                                    a.load.call(t, r, a)
                                }
                            }).attr("src", i.attr("data-" + a.data_attribute))
                        }
                    });
                    if (0 !== a.event.indexOf("scroll")) {
                        i.on(a.event, function () {
                            if (!t.loaded) {
                                i.trigger("appear")
                            }
                        })
                    }
                });
                o.on("resize", function () {
                    h()
                });
                if (/(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion)) {
                    o.on("pageshow", function (t) {
                        if (t.originalEvent && t.originalEvent.persisted) {
                            f.each(function () {
                                e(this).trigger("appear")
                            })
                        }
                    })
                }
                e(i).ready(function () {
                    h()
                });
                return this
            };
            e.belowthefold = function (i, r) {
                var f;
                if (r.container === n || r.container === t) {
                    f = (t.innerHeight ? t.innerHeight : o.height()) + o.scrollTop()
                } else {
                    f = e(r.container).offset().top + e(r.container).height()
                }
                return f <= e(i).offset().top - r.threshold
            };
            e.rightoffold = function (i, r) {
                var f;
                if (r.container === n || r.container === t) {
                    f = o.width() + o.scrollLeft()
                } else {
                    f = e(r.container).offset().left + e(r.container).width()
                }
                return f <= e(i).offset().left - r.threshold
            };
            e.abovethetop = function (i, r) {
                var f;
                if (r.container === n || r.container === t) {
                    f = o.scrollTop()
                } else {
                    f = e(r.container).offset().top
                }
                return f >= e(i).offset().top + r.threshold + e(i).height()
            };
            e.leftofbegin = function (i, r) {
                var f;
                if (r.container === n || r.container === t) {
                    f = o.scrollLeft()
                } else {
                    f = e(r.container).offset().left
                }
                return f >= e(i).offset().left + r.threshold + e(i).width()
            };
            e.inviewport = function (t, i) {
                return !e.rightoffold(t, i) && !e.leftofbegin(t, i) && !e.belowthefold(t, i) && !e.abovethetop(t, i)
            };
            e.extend(e.expr[":"], {
                "below-the-fold": function (t) {
                    return e.belowthefold(t, {threshold: 0})
                }, "above-the-top": function (t) {
                    return !e.belowthefold(t, {threshold: 0})
                }, "right-of-screen": function (t) {
                    return e.rightoffold(t, {threshold: 0})
                }, "left-of-screen": function (t) {
                    return !e.rightoffold(t, {threshold: 0})
                }, "in-viewport": function (t) {
                    return e.inviewport(t, {threshold: 0})
                }, "above-the-fold": function (t) {
                    return !e.belowthefold(t, {threshold: 0})
                }, "right-of-fold": function (t) {
                    return e.rightoffold(t, {threshold: 0})
                }, "left-of-fold": function (t) {
                    return !e.rightoffold(t, {threshold: 0})
                }
            })
        })(e, window, document)
    }
});