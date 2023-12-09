export type Product = {
    id: number,
    scrape_site_id: number,
    name: string,
    category_id:number,
    thumbnail:string
}

export type ProductDetail = {
    id: number;
    scrape_site_id: number;
    name: string;
    category_id: number;
    price: number;
    description: string;
    images: string[];
};