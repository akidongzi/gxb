var app = new Vue({
    delimiters: ['${', '}'],
    el: '.index-list-container',
    data: {
        subject_id: $('#SUBJECT_ID').val(),
        countries: [],
        cities: [],
        searchFormStorageKey: 'cicic-jlhd-sform-data',
        defaultSearchForm: null,
        searchForm: {
            brandVal: '', // 品牌类型
            countriesVal: '', // 国家id
            countriesName: '', // 国家名称
            cityVal: '', // 城市id
            cityName: '', // 城市名称
            childVal: '', // 子活动
            dateRange: [], // 日期范围
            mediaVal: '', // 媒体来源
            materialVal: '' // 素材类型
        },
        articles: {
            current_page: 1, // 当前页码
            to: 45, // 请求到第几条
            total: 76, // 一共多少条数据
            data: []
        },
        tagColor: ['#ED1D26', '#F79421', '#8DC63E', '#026FBE', '#8F1184', '#000000', '#CF0071'],
        requestFlag: true,
        tagRequestFlag: true,
        moreMsg: '加载更多',
        isSearch: false,
        dataLoading: true
    },
    methods: {
        //保存搜索条件到本地
        saveSearchForm: function () {
            localStorage.setItem(this.searchFormStorageKey, JSON.stringify(this.searchForm));
        },
        clearLocalSearchFormData: function () {
            localStorage.removeItem(this.searchFormStorageKey);
        },
        //尝试从本地数据恢复表单选项
        resumeSearchForm: function () {
            var formData = localStorage.getItem(this.searchFormStorageKey);
            if (formData) {
                this.searchForm = JSON.parse(formData);
                return true;
            }
            return false;
        },
        // 搜索
        handleSearch: function () {
            var that = this
            that.requestFlag = true
            that.articles.current_page = 1
            that.isSearch = true
            console.log(that.searchForm)
            this.dataLoading = true;
            this.getWaterfallList(function () {
                that.saveSearchForm();
                that.dataLoading = false;
            })
        },
        //重置搜索表单
        resetSearch: function () {
            this.searchForm = JSON.parse(JSON.stringify(this.defaultSearchForm));
            this.clearLocalSearchFormData();
            this.handleSearch();
        },
        // 加载更多
        handleLoadMore: function () {
            var that = this
            that.getWaterfallList()
        },
        // 选择国家
        countriesChange: function (index) {
            var that = this
            if (index + '' !== '') {
                var chouseCountry = that.countries[index]
                that.searchForm.countriesName = chouseCountry.display
                that.searchForm.cityVal = ''
                that.getCityList(chouseCountry.id)
            } else {
                that.searchForm.countriesVal = ''
                that.searchForm.countriesName = ''
                that.searchForm.cityVal = ''
            }
        },
        // 选择城市
        citiesChange: function (index) {
            var that = this
            if (index + '' !== '') {
                var chouseCity = that.cities[index]
                that.searchForm.cityName = chouseCity.display
            } else {
                that.searchForm.cityVal = ''
                that.searchForm.cityName = ''
            }
        },
        // 瀑布流
        waterfall: function () {
            (function () {
                minigrid('.waterfall__grid', '.waterfall__list', 6, null,
                    function () {
                        var d = document.querySelector('.waterfall');
                        d.style.opacity = 1;
                    }
                );
                window.addEventListener('resize', function () {
                    minigrid('.waterfall__grid', '.waterfall__list');
                });
            })();
        },
        // 请求瀑布流接口数据
        getWaterfallList: function (callback) {
            var that = this
            if (that.requestFlag == false) {
                return
            }

            var searObj = {
                page: that.articles.current_page, // 列表数据翻页页码。默认值=1
                type: that.searchForm.materialVal, // 素材类型。0=不限；1=文章；2=图集。默认值=0。支持多选，英文半角逗号分隔
                ats: that.searchForm.dateRange[0] || null, // 活动时间范围：起始时间。默认值=null
                ate: that.searchForm.dateRange[1] || null, // 活动时间范围：结束时间。默认值=null
                act: that.searchForm.brandVal, // 品牌活动名称。默认值=null
                cntry: that.searchForm.countriesName, // 国家。默认值=null
                city: that.searchForm.cityName, // 城市。默认值=null
                sact: that.searchForm.childVal,
                ms: that.searchForm.mediaVal, // 媒体来源。默认值=null。支持多选，英文半角逗号分隔
            }

            that.requestFlag = false
            cAjax({
                method: 'GET',
                url: '/api/v2/subject/' + that.subject_id,
                data: {
                    fetch: 'articles',
                    articles: searObj
                },
                callback: function (res) {
                    console.log('文章列表', res)
                    if (that.isSearch) {
                        that.articles.to = res.articles.to
                        that.articles.total = res.articles.total
                        that.articles.data = res.articles.data
                        that.articles.current_page = parseInt(res.articles.current_page + 1)
                    } else {
                        if (res.articles.to) {
                            that.articles.current_page = parseInt(res.articles.current_page + 1)
                            that.articles.to = res.articles.to
                            that.articles.total = res.articles.total
                            for (var k in res.articles.data) {
                                that.articles.data.push(res.articles.data[k])
                            }
                            // that.getTagList()
                        }
                    }
                    that.isSearch = false
                    setTimeout(function () {
                        that.requestFlag = true
                        if (that.articles.data.length) {
                            that.waterfall()
                        }
                        if (res.articles.to == res.articles.total) {
                            that.requestFlag = false
                            that.moreMsg = '没有更多数据了'
                        } else {
                            that.requestFlag = true
                            that.moreMsg = '加载更多'
                        }
                    }, 100)

                    if (callback) {
                        callback();
                    }
                },
                errorCallback: function (error) {
                    alert(error)
                }
            })
        },
        // 获取标签接口
        getTagList: function () {
            var that = this
            if (!that.tagRequestFlag) {
                return
            }
            cAjax({
                method: 'GET',
                url: '/api/v2/subject/' + that.subject_id,
                data: {
                    fetch: 'tags'
                },
                callback: function (res) {
                    console.log(res)
                    that.tagRequestFlag = false
                    var temp = {
                        id: 9999999999,
                        type: '4',
                        tagBottom: res.tags
                    }
                    that.articles.data.splice(1, 0, temp)
                    setTimeout(function () {
                        that.waterfall()
                        console.log(123)
                        console.log(that.articles)
                    }, 10)
                },
                errorCallback: function (error) {
                    alert(error)
                }
            })
        },
        // 获取国家列表接口
        getCountriesList: function () {
            var that = this
            cAjax({
                method: 'GET',
                url: '/api/v1/region',
                data: {},
                callback: function (res) {
                    that.countries = res.countries
                },
                errorCallback: function (error) {
                    alert(error)
                }
            })
        },
        // 获取城市列表接口
        getCityList: function (countryId) {
            var that = this
            cAjax({
                method: 'GET',
                url: '/api/v1/region',
                data: {
                    country_id: countryId
                },
                callback: function (res) {
                    that.cities = res.cities
                },
                errorCallback: function (error) {
                    alert(error)
                }
            })
        }
    },
    mounted: function () {
    	var that = this;
        this.defaultSearchForm = JSON.parse(JSON.stringify(this.searchForm));
        if (this.resumeSearchForm()) {
            console.log('resume form data');
            this.handleSearch();
        } else {
            this.getWaterfallList(function () {
                that.dataLoading = false;
            });
        }
        this.getCountriesList();
    }
})

// 轮播图
new Swiper('.bannerbox .swiper-container', {
    loop : true,
    autoplay: 5000,
    autoplayDisableOnInteraction : false,
    paginationClickable: true
});
