import { createStore } from 'vuex'
import api from "@/api";
import router from "@/router";

// Нужно было это в модули всё разнести по-хорошему, но тут не так уж и много
export default createStore<any>({
  state: {
      files: [],
      meta: [],
      currentPage: 'main',
      query: null,
      showConfirm: false,
      confirmCallback: null,
  },
  getters: {

  },
  mutations: {
      SET_FILES(state, payload) {
          state.files = payload
      },
      SET_META(state, payload) {
          state.meta = payload
      },
      SET_PAGE(state, payload) {
          state.currentPage = payload
      },
      SET_QUERY(state, payload) {
          state.query = payload
      },
      SET_SHOW_CONFIRM(state, payload) {
          state.showConfirm = payload
      },
      SET_CONFIRM_CALLBACK(state, payload) {
          state.confirmCallback = payload
      },
  },
  actions: {
      confirm(context) {
          // @ts-ignore
          context.state.confirmCallback?.()
      },
      async fetchFiles(context, page: number) {

          const params: {query?: string; page?: number} = {};
          if(context.state.query) {
              params.query = context.state.query;
          }
          if(page) {
              params.page = page;
          }
          const {data: {
              data, meta
          }} = await api.get('files',{params});
          context.commit('SET_META', meta)
          if(page) {

              context.commit('SET_FILES', [...context.state.files, ...data])
          } else {
              context.commit('SET_FILES', data)
          }
      },
      async deleteFile(context, payload) {
          const {data: {
              success,
              message
          }} = await api.delete(
              `files/${payload}`
          );

          if(success) {
              context.commit('SET_SHOW_CONFIRM', false);
              await context.dispatch("fetchFiles")
          } else {
              alert(message)
          }
      },
      async createFile(context, payload: {title: string; attachment: File}) {

          const formData = new FormData();
          formData.append('attachment', payload.attachment)
          formData.append('title', payload.title)

          try {
              const {data: {
                  id,
                  message
              }} = await api.post(
                  `files`,
                  formData, {
                      headers: {
                          'Content-Type': 'multipart/form-data'
                      }
                  }
              );

              if(message) {
                  alert(message)
              } else {
                  await context.dispatch("fetchFiles")
                  await router.push({path: '/'})
              }
          } catch (e) {}
      },

  },
  modules: {
  }
})
