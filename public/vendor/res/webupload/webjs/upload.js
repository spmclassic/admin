(function (e) {
    e(function () {
        var a = e("#uploader"), i = e('<ul class="filelist"></ul>').appendTo(a.find(".queueList")), t = a.find(".statusBar"), s = t.find(".info"), n = a.find(".uploadBtn"), r = a.find(".placeholder"), l = t.find(".progress").hide(), o = 0, d = 0, c = window.devicePixelRatio || 1, p = 110 * c, u = 110 * c, f = "pedding", m = {}, h = function () {
            var e = new Image;
            var a = true;
            e.onload = e.onerror = function () {
                if (this.width != 1 || this.height != 1) {
                    a = false
                }
            };
            e.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
            return a
        }(), b = function () {
            var e;
            try {
                e = navigator.plugins["Shockwave Flash"];
                e = e.description
            } catch (a) {
                try {
                    e = new ActiveXObject("ShockwaveFlash.ShockwaveFlash").GetVariable("$version")
                } catch (a) {
                    e = "0.0"
                }
            }
            e = e.match(/\d+/g);
            return parseFloat(e[0] + "." + e[1], 10)
        }(), v = function () {
            var e = document.createElement("p").style, a = "transition" in e || "WebkitTransition" in e || "MozTransition" in e || "msTransition" in e || "OTransition" in e;
            e = null;
            return a
        }(), g;
        if (!WebUploader.Uploader.support("flash")) {
            if (b) {
                (function (e) {
                    window["expressinstallcallback"] = function (e) {
                        switch (e) {
                            case"Download.Cancelled":
                                alert("您取消了更新！");
                                break;
                            case"Download.Failed":
                                alert("安装失败");
                                break;
                            default:
                                alert("安装已成功，请刷新！");
                                break
                        }
                        delete window["expressinstallcallback"]
                    };
                    var a = "./expressInstall.swf";
                    var i = '<object type="application/' + 'x-shockwave-flash" data="' + a + '" ';
                    if (WebUploader.browser.ie) {
                        i += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" '
                    }
                    i += 'width="100%" height="100%" style="outline:0">' + '<param name="movie" value="' + a + '" />' + '<param name="wmode" value="transparent" />' + '<param name="allowscriptaccess" value="always" />' + "</object>";
                    e.html(i)
                })(a)
            } else {
                a.html('<a href="http://Www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://Www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>')
            }
            return
        } else if (!WebUploader.Uploader.support()) {
            alert("Web Uploader 不支持您的浏览器！");
            return
        }
        g = WebUploader.create({
            pick: {id: "#filePicker", label: "点击选择图片"},
            formData: {uid: 123},
            dnd: "#dndArea",
            paste: "#uploader",
            chunked: false,
            chunkSize: 512 * 1024,
            server: "/system/materials/upload",
            disableGlobalDnd: true,
            fileNumLimit: 300,
            fileSizeLimit: 200 * 1024 * 1024,
            fileSingleSizeLimit: 2 * 1024 * 1024
        });
        g.on("dndAccept", function (e) {
            var a = false, i = e.length, t = 0, s = "text/plain;application/javascript ";
            for (; t < i; t++) {
                if (~s.indexOf(e[t].type)) {
                    a = true;
                    break
                }
            }
            return !a
        });
        g.addButton({id: "#filePicker2", label: "继续添加"});
        g.on("ready", function () {
            window.uploader = g
        });
        function w(a) {
            var t = e('<li id="' + a.id + '">' + '<p class="title">' + a.name + "</p>" + '<p class="imgWrap"></p>' + '<p class="progress"><span></span></p>' + "</li>"), s = e('<div class="file-panel">' + '<span class="cancel">删除</span>' + '<span class="rotateRight">向右旋转</span>' + '<span class="rotateLeft">向左旋转</span></div>').appendTo(t), n = t.find("p.progress span"), r = t.find("p.imgWrap"), l = e('<p class="error"></p>'), o = function (e) {
                switch (e) {
                    case"exceed_size":
                        text = "文件大小超出";
                        break;
                    case"interrupt":
                        text = "上传暂停";
                        break;
                    default:
                        text = "上传失败，请重试";
                        break
                }
                l.text(text).appendTo(t)
            };
            if (a.getStatus() === "invalid") {
                o(a.statusText)
            } else {
                r.text("预览中");
                g.makeThumb(a, function (a, i) {
                    var t;
                    if (a) {
                        r.text("不能预览");
                        return
                    }
                    if (h) {
                        t = e('<img src="' + i + '">');
                        r.empty().append(t)
                    } else {
                        e.ajax("../../server/preview.php", {
                            method: "POST",
                            data: i,
                            dataType: "json"
                        }).done(function (a) {
                            if (a.result) {
                                t = e('<img src="' + a.result + '">');
                                r.empty().append(t)
                            } else {
                                r.text("预览出错")
                            }
                        })
                    }
                }, p, u);
                m[a.id] = [a.size, 0];
                a.rotation = 0
            }
            a.on("statuschange", function (e, i) {
                if (i === "progress") {
                    n.hide().width(0)
                } else if (i === "queued") {
                    t.off("mouseenter mouseleave");
                    s.remove()
                }
                if (e === "error" || e === "invalid") {
                    console.log(a.statusText);
                    o(a.statusText);
                    m[a.id][1] = 1
                } else if (e === "interrupt") {
                    o("interrupt")
                } else if (e === "queued") {
                    m[a.id][1] = 0
                } else if (e === "progress") {
                    l.remove();
                    n.css("display", "block")
                } else if (e === "complete") {
                    t.append('<span class="success"></span>')
                }
                t.removeClass("state-" + i).addClass("state-" + e)
            });
            t.on("mouseenter", function () {
                s.stop().animate({height: 30})
            });
            t.on("mouseleave", function () {
                s.stop().animate({height: 0})
            });
            s.on("click", "span", function () {
                var i = e(this).index(), t;
                switch (i) {
                    case 0:
                        g.removeFile(a);
                        return;
                    case 1:
                        a.rotation += 90;
                        break;
                    case 2:
                        a.rotation -= 90;
                        break
                }
                if (v) {
                    t = "rotate(" + a.rotation + "deg)";
                    r.css({"-webkit-transform": t, "-mos-transform": t, "-o-transform": t, transform: t})
                } else {
                    r.css("filter", "progid:DXImageTransform.Microsoft.BasicImage(rotation=" + ~~(a.rotation / 90 % 4 + 4) % 4 + ")")
                }
            });
            t.appendTo(i)
        }

        function k(a) {
            var i = e("#" + a.id);
            delete m[a.id];
            x();
            i.off().find(".file-panel").off().end().remove()
        }

        function x() {
            var a = 0, i = 0, t = l.children(), s;
            e.each(m, function (e, t) {
                i += t[0];
                a += t[0] * t[1]
            });
            s = i ? a / i : 0;
            t.eq(0).text(Math.round(s * 100) + "%");
            t.eq(1).css("width", Math.round(s * 100) + "%");
            y()
        }

        function y() {
            var e = "", a;
            if (f === "ready") {
                e = "选中" + o + "张图片，共" + WebUploader.formatSize(d) + "。"
            } else if (f === "confirm") {
                a = g.getStats();
                if (a.uploadFailNum) {
                    e = "已成功上传" + a.successNum + "张照片至XX相册，" + a.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                }
            } else {
                a = g.getStats();
                e = "共" + o + "张（" + WebUploader.formatSize(d) + "），已上传" + a.successNum + "张";
                if (a.uploadFailNum) {
                    e += "，失败" + a.uploadFailNum + "张"
                }
            }
            s.html(e)
        }

        function A(a) {
            var s, o;
            if (a === f) {
                return
            }
            n.removeClass("state-" + f);
            n.addClass("state-" + a);
            f = a;
            switch (f) {
                case"pedding":
                    r.removeClass("element-invisible");
                    i.hide();
                    t.addClass("element-invisible");
                    g.refresh();
                    break;
                case"ready":
                    r.addClass("element-invisible");
                    e("#filePicker2").removeClass("element-invisible");
                    i.show();
                    t.removeClass("element-invisible");
                    g.refresh();
                    break;
                case"uploading":
                    e("#filePicker2").addClass("element-invisible");
                    l.show();
                    n.text("暂停上传");
                    break;
                case"paused":
                    l.show();
                    n.text("继续上传");
                    break;
                case"confirm":
                    l.hide();
                    n.text("开始上传").addClass("disabled");
                    o = g.getStats();
                    if (o.successNum && !o.uploadFailNum) {
                        A("finish");
                        return
                    }
                    break;
                case"finish":
                    o = g.getStats();
                    if (o.successNum) {
                        location.href ="/system/materials/image";
                    } else {
                        f = "done";
                        location.reload()
                    }
                    break
            }
            y()
        }

        g.onUploadProgress = function (a, i) {
            var t = e("#" + a.id), s = t.find(".progress span");
            s.css("width", i * 100 + "%");
            m[a.id][1] = i;
            x()
        };
        g.onFileQueued = function (e) {
            o++;
            d += e.size;
            if (o === 1) {
                r.addClass("element-invisible");
                t.show()
            }
            w(e);
            A("ready");
            x()
        };
        g.onFileDequeued = function (e) {
            o--;
            d -= e.size;
            if (!o) {
                A("pedding")
            }
            k(e);
            x()
        };
        g.on("all", function (e) {
            var a;
            switch (e) {
                case"uploadFinished":
                    A("confirm");
                    break;
                case"startUpload":
                    A("uploading");
                    break;
                case"stopUpload":
                    A("paused");
                    break
            }
        });
        g.onError = function (e) {
            alert("Eroor: " + e)
        };
        n.on("click", function () {
            if (e(this).hasClass("disabled")) {
                return false
            }
            if (f === "ready") {
                g.upload()
            } else if (f === "paused") {
                g.upload()
            } else if (f === "uploading") {
                g.stop()
            }
        });
        s.on("click", ".retry", function () {
            g.retry()
        });
        s.on("click", ".ignore", function () {
            alert("todo")
        });
        n.addClass("state-" + f);
        x()
    })
})(jQuery);