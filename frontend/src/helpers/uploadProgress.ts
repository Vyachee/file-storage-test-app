import store from "@/store";

export const onUploadProgress = (progressEvent: any) => {
    const { loaded, total } = progressEvent;
    let percent = Math.floor((loaded * 100) / total);
    store.commit('SET_PROGRESS', percent)
    console.log(progressEvent)
    console.log(percent);
    return percent
};
