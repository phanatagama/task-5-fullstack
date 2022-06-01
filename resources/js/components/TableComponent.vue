<template>
    <div class="container">
         <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in articles" :key="article.id">
                    <th scope="row">{{ article.id }}</th>
                    <td>article.title</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                articles: {},
            }
        },
        method: {
            getArticles() {
                axios.get("/api/v1/articles").then(response => {
                    this.articles = response.data.data;                    
                })
            }
        },
        created(){
            this.getArticles();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
