export function imgError(ele, type) {
  switch (type) {
    case 1:
      ele.src =
        "https://view.moezx.cc/images/2017/12/30/Transparent_Akkarin.th.jpg";
      break;
    case 2:
      ele.src = "https://gravatar.shino.cc/avatar/?s=80&d=mm&r=g";
      break;
    default:
      ele.src = "https://view.moezx.cc/images/2018/05/13/image-404.png";
  }
}
