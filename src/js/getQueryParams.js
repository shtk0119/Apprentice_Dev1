/**
 * 
 * @param {string} paramName 
 * @returns URLSearchParams
 */
export const getQueryParams = (paramName) => {
  // 現在のURLを取得
  const currentUrl = window.location.href;

  // 既存のクエリパラメータを取得
  const url = new URL(currentUrl);
  const params = new URLSearchParams(url.search);

  return params.get(paramName);
};