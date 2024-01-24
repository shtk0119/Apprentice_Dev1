/**
 * @param {string} value
 */
export const postDateQueryParams = (value) => {
  // 現在のURLを取得
  const currentUrl = window.location.href;

  // 既存のクエリパラメータを取得
  const url = new URL(currentUrl);
  const params = new URLSearchParams(url.search);

  // URLを更新する前に値が異なるかどうかを確認
  if (params.get('date') !== value) {
    // 日付のクエリパラメータをセット
    params.set('date', value);

    // URLに新しいクエリパラメータをセットして、ページを再読み込み
    url.search = params.toString();
    window.location.href = url.toString();
  }
};