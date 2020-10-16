var vm = new Vue({
    el: "#crud-app",
    data() {
        return {
            searchQuery: '',
            jsonData: [],
            loading: true,
            inputContent: '',
            replyContent: '',
            name: '',
            nameState: null,
            submittedNames: []
        }
    },
    mounted() {
        this.fetchAll();
    },
    methods: {
        addRecord(){
            if(this.inputContent != ''){
                vm.loading = true;
                axios.post('write.php', {
                input: this.inputContent
                })
                .then(function (response) {
                    vm.inputContent = '';
                    vm.fetchAll();
                    alert('提交成功！');
                })
                .catch(function (error) {
                console.log(error);
                });
            } else {
                alert('此问题不能为空！');
            }
            },
            addReply(bvModalEvt, id){
                bvModalEvt.preventDefault();
                if(this.replyContent != ''){
                    vm.loading = true;
                    axios.post('reply.php', {
                    input: this.replyContent,
                    id: id
                    })
                    .then(function (response) {
                        vm.replyContent = '';
                        vm.fetchAll();
                        alert('提交成功！');
                    })
                    .catch(function (error) {
                    console.log(error);
                    });
                } else {
                    alert('回复内容不能为空！');
                }
            },
            fetchAll() {
                axios
                .post('read.php')
                .then(response => {
                    this.jsonData = response.data
                    if (this.jsonData == null) {
                        this.jsonData = ["empty"];
                    }
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
            },
            searchData(searchQuery) {
                return this.jsonData.filter(row => {
                    if(JSON.stringify(row).includes(searchQuery)) {
                        return row;
                    }
                })
            },
    }
})